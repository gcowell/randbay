<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('recipient_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->text('type');
            $table->text('unread');
            //Additional Info
            $table->text('item_description')->nullable();
            $table->text('item_img_path')->nullable();
            $table->text('item_rating')->nullable();
            $table->text('item_country_of_origin')->nullable();



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
        Schema::drop('notifications');
    }
}
