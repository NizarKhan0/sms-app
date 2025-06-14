<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->text('diagnosis');
            $table->string('reading_skills');
            $table->string('writing_skills');
            $table->text('school_readiness');
            $table->text('motor_skills');
            $table->text('behaviour_skills');
            $table->text('sensory_issues');
            $table->text('communication_skills');
            $table->text('other_medical_conditions');
            $table->text('tips_and_tricks');
            $table->boolean('is_active')->default(true); // Active/inactive toggle
            $table->foreignId('academic_classes_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
