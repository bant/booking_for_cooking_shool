<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->comment('スタッフID');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->unsignedBigInteger('course_id')->comment('コースID');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->boolean('is_zoom')->nullable()->comment('ZOOM判別フラグ');
            $table->unsignedInteger('capacity')->comment('定員'); 
            $table->unsignedInteger('number_of_reservation')->comment('予約した人数'); 
            $table->string('zoom_invitation')->comment('zoom招待状');
            $table->dateTime('start')->comment('開始時刻');
            $table->dateTime('end')->comment('終了時刻');
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
        Schema::dropIfExists('schedules');
    }
}
