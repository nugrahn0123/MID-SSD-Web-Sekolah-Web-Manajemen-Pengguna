<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teaching_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();
            $table->date('teaching_date');
            $table->string('material');
            $table->string('learning_method');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['teacher_id', 'teaching_date']);
            $table->index(['class_id', 'teaching_date']);
        });

        Schema::create('bk_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->enum('case_type', ['konseling', 'pelanggaran', 'prestasi']);
            $table->date('case_date');
            $table->string('title');
            $table->text('description');
            $table->text('follow_up_notes')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'case_date']);
            $table->index(['teacher_id', 'case_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bk_cases');
        Schema::dropIfExists('teaching_journals');
    }
};