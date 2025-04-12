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
    Schema::create('user_histories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('admin_id'); // người thao tác
        $table->unsignedBigInteger('user_id')->nullable(); // người dùng bị ảnh hưởng
        $table->string('action'); // add, edit, delete
        $table->text('note')->nullable(); // ghi chú chi tiết
        $table->timestamps();

        $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_histories');
    }
};
