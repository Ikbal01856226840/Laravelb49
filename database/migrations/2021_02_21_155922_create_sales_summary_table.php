<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_summary', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->integer('customer_id')->constrained('customers');
            $table->float('total_amount')->nullable();
            $table->float('discount_percentage')->nullable();
            $table->float('vat_percentage')->nullable();
            $table->float('grand_total')->nullable();
            $table->integer('table_id')->constrained('tables')->nullable();
            $table->integer('sold_by')->constrained('users')->nullable();
            $table->integer('user_id')->constrained('users')->comment('Shop Parent ID')->nullable();
            $table->integer('sell_type')->comment('0=Restaurant, 1=Online')->nullable();
            $table->integer('payment_type')->comment('0=Cash, 1=Mobile Banking, 2=Card')->nullable();
            $table->integer('status')->comment('0=Pending, 1=Sold, 2=Cancelled')->nullable();
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
        Schema::dropIfExists('sales_summary');
    }
}
