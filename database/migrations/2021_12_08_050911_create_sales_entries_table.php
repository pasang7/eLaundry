<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('receipt_number');
            $table->string('estimated_delivery_date');
            $table->integer('product_id');
            $table->float('product_rate');
            $table->float('product_quantity');
            $table->integer('item_total');
            $table->boolean('is_full_cash')->nullable();
            $table->boolean('is_full_bank')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->boolean('is_full_credit')->nullable();
            $table->boolean('is_partial_cash')->nullable();
            $table->integer('partial_cash_paid')->nullable();
            $table->boolean('is_partial_bank')->nullable();
            $table->integer('partial_bank_paid')->nullable();
            $table->boolean('is_sales')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_entries');
    }
}
