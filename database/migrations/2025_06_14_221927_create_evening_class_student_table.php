<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evening_class_student', function (Blueprint $table) {
            $table->id(); // optional, boleh buang kalau nak pure pivot table
            $table->foreignId('evening_class_id')
                ->nullable()
                ->constrained('evening_classes')
                ->onDelete('cascade');
            $table
                ->foreignId('student_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['evening_class_id', 'student_id']); // elak duplicate entries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evening_class_student');
    }
};
