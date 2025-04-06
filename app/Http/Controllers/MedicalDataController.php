<?php

namespace App\Http\Controllers;

use App\Models\MedicalData;
use Illuminate\Http\Request;

class MedicalDataController extends Controller
{
    /**
     * Hiển thị danh sách dữ liệu y khoa (hỗ trợ tìm kiếm và sắp xếp theo ID).
     */
    public function index(Request $request)
    {
        $query = MedicalData::query();

        // Tìm kiếm theo tiêu đề hoặc mô tả
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Sắp xếp theo ID tăng dần
        $medicalData = $query->orderBy('id', 'asc')->get();

        return view('admin.manage_medical_data', compact('medicalData'));
    }

    /**
     * Hiển thị form thêm mới dữ liệu y khoa.
     */
    public function create()
    {
        return view('admin.create_medical_data');
    }

    /**
     * Lưu dữ liệu y khoa mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Lưu dữ liệu vào cơ sở dữ liệu
        MedicalData::create($request->only(['title', 'description']));

        // Chuyển hướng và thông báo thành công
        return redirect()->route('admin.manage_medical_data')
                         ->with('success', 'Dữ liệu y khoa đã được thêm.');
    }

    /**
     * Hiển thị form chỉnh sửa dữ liệu y khoa.
     */
    public function edit($id)
    {
        // Lấy dữ liệu y khoa theo ID
        $medicalData = MedicalData::findOrFail($id);
        return view('admin.edit_medical_data', compact('medicalData'));
    }

    /**
     * Cập nhật dữ liệu y khoa.
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Lấy dữ liệu y khoa theo ID và cập nhật
        $medicalData = MedicalData::findOrFail($id);
        $medicalData->update($request->only(['title', 'description']));

        // Chuyển hướng và thông báo thành công
        return redirect()->route('admin.manage_medical_data')
                         ->with('success', 'Dữ liệu y khoa đã được cập nhật.');
    }

    /**
     * Xóa dữ liệu y khoa.
     */
    public function destroy($id)
    {
        // Lấy dữ liệu y khoa theo ID và xóa
        $medicalData = MedicalData::findOrFail($id);
        $medicalData->delete();

        // Chuyển hướng và thông báo thành công
        return redirect()->route('admin.manage_medical_data')
                         ->with('success', 'Dữ liệu y khoa đã được xóa.');
    }
}
