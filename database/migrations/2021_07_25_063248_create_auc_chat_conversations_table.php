<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucChatConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_chat_conversations', function (Blueprint $table) {
            $table->string('id', 150)->primary();
            $table->string('chatId', 150);
            $table->string('senderId', 50)->nullable();
            $table->text('message')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();

            $table->foreign('senderId')->references('id')->on('auc_users');
            $table->foreign('chatId')->references('id')->on('auc_chats');
   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_chat_conversations');
    }
}
