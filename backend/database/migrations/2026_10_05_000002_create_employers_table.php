<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employers', function (Blueprint $table) {
            $table->id('employer_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('company_name', 255);
            $table->string('registration_number', 100)->unique();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('employers');
    }
};
