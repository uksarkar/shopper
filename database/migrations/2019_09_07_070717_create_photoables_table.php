<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photoables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('photoable_id')->unsigned()->index();
            $table->integer('photo_id')->unsigned()->index();
            $table->string('photoable_type');

            // $table->foreign('photo_id')->references('id')->on('photos');
            // $table->foreign('photoable_id')->references('id')->on('products');
            
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
        Schema::dropIfExists('photoables');
    }
}
