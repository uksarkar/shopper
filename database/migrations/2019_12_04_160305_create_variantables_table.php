<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variantables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('variantable_id')->unsigned()->index();
            $table->integer('variant_id')->unsigned()->index();
            $table->string('variantable_type');
            $table->integer('amounts');
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
        Schema::dropIfExists('variantable');
    }
}
