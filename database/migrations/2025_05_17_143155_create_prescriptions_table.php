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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();

            // Use string to match patients.patient_id varchar(255)
            $table->string('patient_id');

            // other columns...
            $table->string('medication');
            $table->text('notes')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
