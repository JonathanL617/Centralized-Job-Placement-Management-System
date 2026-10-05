<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('employer_id');
            $table->string('title', 255);
            $table->text('technical_requirements')->nullable();
            $table->enum('pipeline_type', ['academic', 'direct-hire']);
            $table->enum('admin_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->date('open_date')->nullable();
            $table->date('close_date')->nullable();
            $table->timestamps(); // created_at, updated_at
            $table->foreign('employer_id')->references('employer_id')->on('employers')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('jobs');
    }
};
