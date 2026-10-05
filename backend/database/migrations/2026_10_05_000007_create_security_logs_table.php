<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('action_type', ['CREATE', 'READ', 'UPDATE', 'DELETE', 'DOWNLOAD']);
            $table->string('target_entity', 255);
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('security_logs');
    }
};
