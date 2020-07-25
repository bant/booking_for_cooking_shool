<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('コース名称');
            $table->unsignedBigInteger('staff_id')->comment('先生ID');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->unsignedInteger('price')->comment('価格');
//            $table->unsignedInteger('price_down')->comment('値引き価格');
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
        Schema::dropIfExists('courses');
    }
}
