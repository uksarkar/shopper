<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta__texts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('config_id');
            $table->string('text');
            $table->string('key_1')->nullable();
            $table->string('key_2')->nullable();
            $table->string('key_3')->nullable();
            $table->string('key_4')->nullable();
            $table->string('key_5')->nullable();
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
        Schema::dropIfExists('meta__texts');
    }
}
