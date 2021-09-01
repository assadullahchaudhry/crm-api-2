<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucTaskAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_task_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('taskId', 50)->index();
            $table->string('name');
            $table->string('type', 5);
            $table->string('size', 10);
            $table->string('localPath');
            $table->string('url' );
            $table->timestamps();

            $table->foreign('taskId')->references('id')->on('auc_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_task_attachments');
    }
}
