<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('教室名称');
            $table->unsignedBigInteger('staff_id')->unique()->comment('スタッフID');  
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->string('address')->comment('住所');
            $table->string('tel')->comment('電話番号');
            $table->string('description')->comment('詳細D');
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
        Schema::dropIfExists('rooms');
    }
}
