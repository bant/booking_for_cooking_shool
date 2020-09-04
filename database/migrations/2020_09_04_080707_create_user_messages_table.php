<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction');
            $table->unsignedBigInteger('user_id')->comment('生徒ID');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('staff_id')->nullable()->comment('先生ID');
            $table->unsignedBigInteger('admin_id')->nullable()->comment('管理者ID');
            $table->unsignedBigInteger('reservation_id')->nullable()->comment('予約番号');
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
        Schema::dropIfExists('user_messages');
    }
}
