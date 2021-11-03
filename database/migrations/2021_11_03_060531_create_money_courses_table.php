<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money__courses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('from_currency_id');
            $table->foreign('from_currency_id')->on('money__currencies')->references('id');

            $table->unsignedBigInteger('to_currency_id');
            $table->foreign('to_currency_id')->on('money__currencies')->references('id');

            $table->integer('nominal');
            $table->float('value');

            $table->timestamp('actual_at');

            $table->unique(['from_currency_id', 'to_currency_id', 'actual_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money__courses');
    }
}
