from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from fastapi.middleware.cors import CORSMiddleware
import os
from dotenv import load_dotenv
from openai import OpenAI
import logging
import time

# Cấu hình logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Load API Key từ .env
load_dotenv()
api_key = os.getenv("KEY_API_GPT")

if not api_key:
    logger.error("❌ API Key không tìm thấy! Kiểm tra lại .env")
    raise ValueError("❌ API Key không tìm thấy! Kiểm tra lại .env")

# Tạo client OpenAI
try:
    client = OpenAI(api_key=api_key)
    logger.info("✅ Đã khởi tạo OpenAI client")
except Exception as e:
    logger.error(f"❌ Lỗi khi khởi tạo OpenAI client: {str(e)}")
    raise

app = FastAPI()

# Cấu hình CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=[
        "http://127.0.0.1:8001",
        "http://localhost:8001",
        "http://127.0.0.1:8000",  # Thêm nếu Laravel chạy trên cổng khác
        "http://localhost:8000",
    ],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Model nhận dữ liệu
class ChatRequest(BaseModel):
    message: str

@app.get("/")
async def read_root():
    return {"message": "✅ API Chatbot Y Học GPT-4o đang chạy!"}

@app.post("/chatbot")
async def chatbot_response(request: ChatRequest):
    user_message = request.message.strip()

    if not user_message:
        logger.warning("Tin nhắn rỗng từ client")
        raise HTTPException(status_code=400, detail="❌ Tin nhắn không được để trống!")

    try:
        logger.info(f"Nhận tin nhắn: {user_message}")

        # Xử lý logic cho tin nhắn VIP
        is_vip = "Trả lời chuyên sâu" in user_message
        system_prompt = (
            "Bạn là một bác sĩ AI chuyên về y học. Hãy trả lời các câu hỏi liên quan đến sức khỏe một cách chính xác, dễ hiểu, và cung cấp lời khuyên hữu ích."
        )
        if is_vip:
            system_prompt += (
                " Hãy cung cấp câu trả lời chi tiết, có dẫn chứng y khoa nếu cần, và trình bày rõ ràng."
            )

        # Thêm retry logic cho OpenAI
        max_retries = 3
        for attempt in range(max_retries):
            try:
                response = client.chat.completions.create(
                    model="gpt-4o",
                    messages=[
                        {"role": "system", "content": system_prompt},
                        {"role": "user", "content": user_message}
                    ],
                    temperature=0.7,
                    max_tokens=1500 if is_vip else 1000,  # Tăng tokens cho VIP
                    timeout=30,  # Timeout cho mỗi yêu cầu
                )
                bot_reply = response.choices[0].message.content.strip()
                logger.info("Gửi phản hồi thành công")
                return {"response": bot_reply}
            except Exception as e:
                logger.warning(f"Thử lần {attempt + 1} thất bại: {str(e)}")
                if attempt == max_retries - 1:
                    raise
                time.sleep(2 ** attempt)  # Exponential backoff

    except Exception as e:
        logger.error(f"🚨 Lỗi khi gọi OpenAI: {str(e)}")
        raise HTTPException(
            status_code=500,
            detail=f"🚨 Không thể xử lý yêu cầu do lỗi từ hệ thống AI: {str(e)}"
        )

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)

