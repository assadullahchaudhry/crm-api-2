<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucChatAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_chat_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('conversationId', 150);
            $table->string('chatId', 150);
            $table->string('senderId', 50);
            $table->string('name');
            $table->string('originalName');
            $table->string('type', 255);
            $table->string('size', 10);
            $table->string('url');
            $table->timestamps();

            $table->foreign('chatId')->references('id')->on('auc_chats')->onDelete('cascade');
            $table->foreign('senderId')->references('id')->on('auc_users')->onDelete('cascade');
            $table->foreign('conversationId')->references('id')->on('auc_chat_conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_chat_attachments');
    }
}
