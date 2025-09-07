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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('grade')->unique();
            $table->integer('min_score');
            $table->integer('max_score');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('late_fee_rate', 5, 2)->default(0.00);
            $table->integer('max_tenor_months')->default(12);
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
