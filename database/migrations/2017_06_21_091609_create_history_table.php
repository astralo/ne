<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->float('price_usd', 20, 10);
            $table->float('price_btc', 20, 10);
            $table->float('volume_usd_24h', 20, 5);
            $table->float('market_cap_usd', 20, 5);
            $table->float('available_supply', 20, 1);
            $table->float('total_supply', 20, 1);
            $table->decimal('percent_change_1h', 6, 2);
            $table->decimal('percent_change_24h', 6, 2);
            $table->decimal('percent_change_7d', 6, 2);
            $table->integer('last_updated')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history', function ($table) {
            $table->dropForeign('history_currency_id_foreign');
        });
        Schema::drop('history');
    }
}
