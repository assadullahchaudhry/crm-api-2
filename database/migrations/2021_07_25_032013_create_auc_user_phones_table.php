<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucUserPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_user_phones', function (Blueprint $table) {
            $table->id();
            $table->string('userId', 50);
            $table->string('phone', 30);
            $table->string('type', 10);
            $table->string('extension', 10)->nullable();
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('auc_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_user_phones');
    }
}
