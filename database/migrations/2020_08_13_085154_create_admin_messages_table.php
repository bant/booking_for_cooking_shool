<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction');
            $table->unsignedBigInteger('admin_id')->comment('管理者ID');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->unsignedBigInteger('staff_id')->nullable()->comment('先生ID');
            $table->unsignedBigInteger('user_id')->nullable()->comment('生徒ID');
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
        Schema::dropIfExists('admin_messages');
    }
}
