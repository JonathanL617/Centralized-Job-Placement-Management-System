<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applications', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('student_id');
            $table->decimal('match_score', 5, 2)->nullable();
            $table->jsonb('skill_gap_report')->nullable();
            $table->enum('tracking_status', ['pending', 'interviewing', 'offered', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
            $table->foreign('job_id')->references('job_id')->on('jobs')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('applications');
    }
};
