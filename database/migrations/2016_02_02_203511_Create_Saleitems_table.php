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
            $table->string('native_currency');
            $table->decimal('price', 10, 2);
            $table->string('international');
            $table->decimal('domestic_postage_cost', 5, 2);
            $table->decimal('world_postage_cost', 5, 2)->nullable();
            $table->string('matched');
            $table->string('country_of_origin');
            $table->string('image_type');
            $table->decimal('currency_rate', 10, 5);
            $table->smallInteger('rating')->nullable();
            $table->decimal('seller_rating')->unsigned();
            $table->timestamp('engaged_until');
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
        Schema::drop('saleitems');
    }
}
