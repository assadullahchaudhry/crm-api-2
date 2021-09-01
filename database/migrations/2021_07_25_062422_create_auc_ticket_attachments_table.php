<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucTicketAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('ticketId', 50)->index();
            $table->string('name');
            $table->string('type', 5);
            $table->string('size', 10);
            $table->string('localPath');
            $table->string('url' );
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
        Schema::dropIfExists('auc_ticket_attachments');
    }
}
