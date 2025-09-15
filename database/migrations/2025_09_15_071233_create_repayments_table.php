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
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->integer('installment_no');
            $table->decimal('due_amount', 15, 2); 
            $table->decimal('penalty_amount', 15, 2)->default(0); 
            $table->date('due_date');
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->date('paid_at')->nullable();
            $table->enum('status', ['pending','paid','overdue'])->default('pending');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};
