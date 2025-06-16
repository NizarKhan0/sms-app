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
            $table->string('full_name');
            $table->string('name')->nullable();
            $table->integer('age');
            $table->longText('diagnosis')->nullable();
            $table->longText('reading_skills')->nullable();
            $table->longText('writing_skills')->nullable();
            $table->longText('numeracy')->nullable();
            $table->longText('school_readiness')->nullable();
            $table->longText('motor_skills')->nullable();
            $table->longText('behaviour_skills')->nullable();
            $table->longText('sensory_issues')->nullable();
            $table->longText('communication_skills')->nullable();
            $table->text('other_medical_conditions')->nullable();
            $table->text('tips_and_tricks')->nullable();
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
