<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driving_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('student_name');
            $table->string('student_category');
            $table->enum('student_type', ['registered', 'walkin'])->default('registered');
            $table->string('student_phone')->nullable();
            $table->string('student_email')->nullable();
            $table->unsignedBigInteger('instructor_id');
            $table->string('instructor_name');
            $table->enum('type', ['Code', 'Driving']);
            $table->enum('status', ['Scheduled', 'In Progress', 'Completed', 'Cancelled', 'No Show'])->default('Scheduled');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration');
            $table->decimal('price', 10, 2);
            $table->enum('payment_status', ['Paid', 'Pending'])->default('Pending');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('vehicle_plate')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add foreign keys after table creation (only if referenced tables exist)
            // Uncomment these after the referenced tables are migrated
            // $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            // $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            // $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driving_sessions');
    }
};
