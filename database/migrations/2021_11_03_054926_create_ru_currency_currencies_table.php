<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuCurrencyCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ru_currency__currencies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 75);
            $table->string('iso_code', 3)->unique()->index();
            $table->string('symbol', 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ru_currency__currencies');
    }
}
