<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_chats', function (Blueprint $table) {
            $table->string('id', 150)->primary();
            $table->string('senderId', 50)->nullable();
            $table->string('recipientId', 50)->nullable();
            $table->timestamps();

            $table->foreign('senderId')->references('id')->on('auc_users');
            $table->foreign('recipientId')->references('id')->on('auc_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_chats');
    }
}
