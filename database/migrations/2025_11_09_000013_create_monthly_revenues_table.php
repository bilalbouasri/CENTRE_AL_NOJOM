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
        Schema::create('monthly_revenues', function (Blueprint $table) {
            $table->id();
            $table->integer('month'); // 1-12
            $table->integer('year');
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->integer('payment_count')->default(0);
            $table->decimal('average_payment', 10, 2)->default(0);
            $table->json('revenue_by_method')->nullable(); // Store revenue breakdown by payment method
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure unique entry per month and year
            $table->unique(['month', 'year'], 'unique_month_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_revenues');
    }
};
