<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportticketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('complainer_id')->unsigned();
            $table->integer('complainee_id')->unsigned();
            $table->text('type');
            $table->text('details');

            $table->integer('transaction_id')->unsigned();
            $table->text('evidence_dir');
            $table->text('evidence_added');

            $table->text('refund_id')->nullable();

            $table->text('resolved');
            $table->text('result')->nullable();
            $table->text('has_support_ticket');

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
        Schema::drop('support_tickets');

    }
}
