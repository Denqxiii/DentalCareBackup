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
        Schema::table('bills', function (Blueprint $table) {
            if (Schema::hasColumn('bills', 'amount_due') && !Schema::hasColumn('bills', 'total_amount')) {
                $table->renameColumn('amount_due', 'total_amount');
            }
            if (Schema::hasColumn('bills', 'amount_paid') && !Schema::hasColumn('bills', 'paid_amount')) {
                $table->renameColumn('amount_paid', 'paid_amount');
            }
            if (!Schema::hasColumn('bills', 'appointment_id')) {
                $table->foreignId('appointment_id')->nullable()->after('patient_id')->constrained('appointments');
            }
            if (!Schema::hasColumn('bills', 'balance')) {
                $table->decimal('balance', 10, 2)->after('paid_amount');
            }
            if (!Schema::hasColumn('bills', 'status')) {
                $table->enum('status', ['pending', 'partial', 'paid'])->default('pending')->after('balance');
            }
            if (!Schema::hasColumn('bills', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('bills', 'due_date')) {
                $table->date('due_date')->after('notes');
            }
            if (!Schema::hasColumn('bills', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            if (Schema::hasColumn('bills', 'total_amount') && !Schema::hasColumn('bills', 'amount_due')) {
                $table->renameColumn('total_amount', 'amount_due');
            }
            if (Schema::hasColumn('bills', 'paid_amount') && !Schema::hasColumn('bills', 'amount_paid')) {
                $table->renameColumn('paid_amount', 'amount_paid');
            }
            $table->dropForeign(['appointment_id']);
            $table->dropColumn(['appointment_id', 'balance', 'status', 'notes', 'due_date', 'deleted_at']);
        });
    }
};
