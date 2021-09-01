<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_tickets', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('companyId', 50);
            $table->string('subject');
            $table->text('description');
            $table->string('status', 10)->default('pending');
            $table->string('createdBy', 50)->nullable();
            $table->string('assignedTo', 50)->nullable();
            $table->string('priority', 15);
            $table->timestamps();

            $table->foreign('companyId')->references('id')->on('auc_companies');
            $table->foreign('createdBy')->references('id')->on('auc_users');
            $table->foreign('assignedTo')->references('id')->on('auc_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_tickets');
    }
}
