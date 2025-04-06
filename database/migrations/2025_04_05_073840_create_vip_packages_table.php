<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vip_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên gói VIP
            $table->text('description'); // Mô tả gói VIP
            $table->decimal('price', 10, 2); // Giá gói VIP
            $table->integer('duration'); // Thời gian sử dụng gói (ví dụ: ngày)
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vip_packages');
    }
};
