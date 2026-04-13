<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('cin')->unique();
            $table->enum('type', ['Code', 'Driving', 'Both', 'Simulator', 'Evaluation'])->default('Both');
            $table->enum('status', ['Active', 'On Leave', 'Inactive', 'Training'])->default('Active');
            $table->enum('experience_level', ['Junior', 'Intermediate', 'Senior', 'Master'])->default('Intermediate');
            $table->integer('years_experience')->default(0);
            $table->date('hire_date')->nullable();
            $table->string('specialization')->nullable();
            $table->string('license_number')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('students_count')->default(0);
            $table->integer('sessions_count')->default(0);
            $table->decimal('completion_rate', 5, 2)->default(0);
            $table->decimal('rating', 3, 1)->default(0);
            $table->decimal('revenue', 10, 2)->default(0);
            $table->json('available_days')->nullable();
            $table->json('available_hours')->nullable();
            $table->json('certifications')->nullable();
            $table->json('schedule')->nullable();
            $table->json('documents')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
