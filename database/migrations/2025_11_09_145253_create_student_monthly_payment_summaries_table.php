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
        Schema::create('student_monthly_payment_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->integer('payment_month'); // 1-12
            $table->integer('payment_year');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('cash');
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure unique summary per student, month, year
            $table->unique(['student_id', 'payment_month', 'payment_year'], 'unique_monthly_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_monthly_payment_summaries');
    }
};
