<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saleitems', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('description');
            $table->string('currency');
            $table->decimal('price', 10, 2);
            $table->string('international');
            $table->decimal('domestic_postage_cost', 5, 2);
            $table->decimal('world_postage_cost', 5, 2)->nullable();
            $table->boolean('matched');
            $table->string('country_of_origin');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('saleitems');
    }
}
