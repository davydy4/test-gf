<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_news', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('position_id');

            $table->date('order_date_from');

            $table->date('order_date_to')->nullable();

            $table->date('delivery_date_from');

            $table->date('delivery_date_to')->nullable();

            $table->float('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_news');
    }
}
