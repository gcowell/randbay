<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('buyer_id')->unsigned();
            $table->integer('seller_id')->unsigned();
            $table->integer('buyorder_id')->unsigned();
            $table->integer('saleitem_id')->unsigned();
            $table->decimal('price', 7, 2);
            $table->decimal('postage_cost', 7, 2);
            $table->string('currency');
            $table->string('payment_complete');
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_paypal_ref')->nullable();
            $table->string('remuneration_complete');
            $table->string('remuneration_paypal_ref')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('item_shipped');
            $table->timestamp('shipped_date')->nullable();
            $table->string('item_received');
            $table->timestamp('received_date')->nullable();
            $table->smallInteger('rating')->nullable();
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
        Schema::drop('transactions');
    }
}
