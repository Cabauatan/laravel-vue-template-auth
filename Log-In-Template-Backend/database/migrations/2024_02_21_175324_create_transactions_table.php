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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();  
            $table->uuid('sales_id');    
            $table->dateTime('transaction_date');     
            $table->string('transaction_type');    
            $table->decimal('vat');     
            $table->decimal('total_payment');     
            $table->decimal('payment')->nullable();     
            $table->decimal('change')->nullable();     


            $table->foreign('sales_id')->references('id')->on('sales');

            $table->timestamps();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
