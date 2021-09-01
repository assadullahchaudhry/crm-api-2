<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_folders', function (Blueprint $table) {
            $table->string('id', 150)->primary();
            $table->string('name');
            $table->string('ownerId', 50);
            $table->timestamps();

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
        Schema::dropIfExists('auc_folders');
    }
}
