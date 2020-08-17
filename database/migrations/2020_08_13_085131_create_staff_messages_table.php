<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction');
            $table->unsignedBigInteger('staff_id')->comment('スタッフID');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->unsignedBigInteger('user_id')->nullable()->comment('生徒ID');
            $table->text('message')->comment('メッセージ');
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('staff_messages');
    }
}
