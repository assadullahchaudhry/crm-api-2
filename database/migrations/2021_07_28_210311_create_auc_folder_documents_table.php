<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucFolderDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_folder_documents', function (Blueprint $table) {
            $table->string('id', 150)->primary();
            $table->string('folderId', 150)->nullable();
            $table->string('ownerId', 50);
            $table->string('originalName');
            $table->string('name');
            $table->string('type', 255);
            $table->string('size', 10);
            $table->string('url');
            $table->timestamps();

            $table->foreign('folderId')->references('id')->on('auc_folders');
            $table->foreign('ownerId')->references('id')->on('auc_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_folder_documents');
    }
}
