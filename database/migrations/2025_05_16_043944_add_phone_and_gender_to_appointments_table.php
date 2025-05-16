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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('phone_number')->after('treatment_id');
            $table->enum('gender', ['Male', 'Female', 'Other'])->after('phone_number');
            $table->renameColumn('message', 'notes'); // Optional but recommended
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'gender']);
            $table->renameColumn('notes', 'message');
        });
    }
};
