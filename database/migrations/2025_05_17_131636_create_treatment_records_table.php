<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('treatment_records', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id');           // match your patients.patient_id type
            $table->unsignedBigInteger('treatment_id');
            $table->unsignedBigInteger('user_id')->nullable(); // doctor/admin who made the treatment, optional
            $table->dateTime('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->string('status')->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys (optional but recommended)
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_records');
    }
};
