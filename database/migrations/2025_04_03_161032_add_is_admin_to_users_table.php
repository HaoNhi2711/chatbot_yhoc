<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm trường 'is_admin' vào sau trường 'password' với giá trị mặc định là 1
            $table->boolean('is_admin')->default(true)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xóa trường 'is_admin' khi rollback migration
            $table->dropColumn('is_admin');
        });
    }
};
