<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('plate')->unique();
            $table->string('vin')->nullable()->unique();
            $table->string('category');
            $table->string('fuel')->default('Gasoline');
            $table->string('transmission')->default('Manual');
            $table->string('color')->nullable();
            $table->enum('status', ['Active', 'Maintenance', 'Inactive', 'Out of Service'])->default('Active');
            $table->integer('mileage')->default(0);
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_policy')->nullable();
            $table->date('technical_inspection')->nullable();
            $table->date('registration_expiry')->nullable();
            $table->string('assigned_instructor')->nullable();
            $table->integer('sessions_count')->default(0);
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('current_value', 10, 2)->nullable();
            $table->decimal('fuel_efficiency', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->json('maintenance_history')->nullable();
            $table->json('documents')->nullable();
            $table->json('incidents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
