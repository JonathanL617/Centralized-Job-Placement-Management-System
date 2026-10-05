<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id('admin_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('staff_id', 100)->unique();
            $table->string('faculty_department', 255);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('administrators');
    }
};
