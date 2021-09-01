<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucTicketRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_ticket_replies', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('companyId', 50);
            $table->string('ticketId', 50);
            $table->text('message');
            $table->string('userId', 50)->nullable();
            $table->timestamps();

            $table->foreign('companyId')->references('id')->on('auc_companies');
            $table->foreign('userId')->references('id')->on('auc_users');
            $table->foreign('ticketId')->references('id')->on('auc_tickets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_ticket_replies');
    }
}
