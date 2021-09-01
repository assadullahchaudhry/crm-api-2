<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucGroupLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_group_locations', function (Blueprint $table) {
            $table->id();
            $table->string('groupId', 50);
            $table->string('address');
            $table->mediumInteger('cityId')->unsigned();
            $table->mediumInteger('stateId')->unsigned();
            $table->mediumInteger('countryId')->unsigned();
            $table->string('postalCode', 30);
            $table->timestamps();

            $table->foreign('groupId')->references('id')->on('auc_groups')->onDelete('cascade');
            $table->foreign('cityId')->references('id')->on('cities');
            $table->foreign('stateId')->references('id')->on('states');
            $table->foreign('countryId')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_group_locations');
    }
}
