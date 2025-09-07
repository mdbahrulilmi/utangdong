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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('amount');
            $table->integer('tenor');
            $table->string('purpose');
            $table->double('interest_rate');
            $table->decimal('total_repayment', 15, 2)->nullable();
            $table->enum('status',['requested','active','completed','rejected'])->default('requested');
            $table->decimal('disbursed_amount', 15, 2)->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
