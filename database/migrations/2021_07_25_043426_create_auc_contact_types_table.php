<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucContactTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_contact_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        DB::table('auc_contact_types')->insert(['name' => 'DO']);
        DB::table('auc_contact_types')->insert(['name' => 'Billing']);
        DB::table('auc_contact_types')->insert(['name' => 'Tech Support']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_contact_types');
    }
}
