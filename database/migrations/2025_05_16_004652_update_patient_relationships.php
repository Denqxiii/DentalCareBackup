<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add missing columns to patients table
        if (!Schema::hasColumn('patients', 'middle_name')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->string('middle_name', 100)->nullable()->after('first_name');
            });
        }

        // Modify appointments table
        Schema::table('appointments', function (Blueprint $table) {
            // Change patient_id to match patients table
            $table->string('patient_id', 20)->change();
            
            // Add foreign key if it doesn't exist
            if (!Schema::hasColumn('appointments', 'patient_id')) {
                $table->string('patient_id', 20)->after('id');
            }
            
            // Add foreign key constraint
            $table->foreign('patient_id')
                ->references('patient_id')
                ->on('patients')
                ->onDelete('cascade');
        });

        // Create medical_histories table if it doesn't exist
        if (!Schema::hasTable('medical_histories')) {
            Schema::create('medical_histories', function (Blueprint $table) {
                $table->id();
                $table->string('patient_id', 20);
                $table->string('condition', 100);
                $table->date('diagnosis_date');
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->foreign('patient_id')
                    ->references('patient_id')
                    ->on('patients')
                    ->onDelete('cascade');
            });
        }

        // Create treatment_records table if it doesn't exist
        if (!Schema::hasTable('treatment_records')) {
            Schema::create('treatment_records', function (Blueprint $table) {
                $table->id();
                $table->string('patient_id', 20);
                $table->date('treatment_date');
                $table->string('treatment_type', 100);
                $table->text('doctor_notes')->nullable();
                $table->timestamps();
                
                $table->foreign('patient_id')
                    ->references('patient_id')
                    ->on('patients')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Don't drop columns in rollback to prevent data loss
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
        });
        
        // Only drop new tables if they exist
        Schema::dropIfExists('treatment_records');
        Schema::dropIfExists('medical_histories');
    }
};
