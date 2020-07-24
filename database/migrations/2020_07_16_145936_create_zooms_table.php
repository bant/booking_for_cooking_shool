<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名称');
            $table->unsignedBigInteger('staff_id')->unique()->comment('スタッフID');;  
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->string('description')->comment('詳細');
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
        Schema::dropIfExists('zooms');
    }
}
