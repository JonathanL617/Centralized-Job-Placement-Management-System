<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->enum('document_type', ['resume', 'offer_letter']);
            $table->string('file_path', 255);
            $table->jsonb('parsed_data')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('application_id')->references('application_id')->on('applications')->onDelete('set null');
        });
    }
    public function down(): void {
        Schema::dropIfExists('documents');
    }
};
