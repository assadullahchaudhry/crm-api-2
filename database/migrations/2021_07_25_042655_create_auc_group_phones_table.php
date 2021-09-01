<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucGroupPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_group_phones', function (Blueprint $table) {
            $table->id();
            $table->string('groupId', 50);
            $table->string('phone', 30);
            $table->string('type', 10);
            $table->timestamps();

            $table->foreign('groupId')->references('id')->on('auc_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_group_phones');
    }
}
