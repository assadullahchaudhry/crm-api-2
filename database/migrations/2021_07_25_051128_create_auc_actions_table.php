<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_actions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        DB::table('auc_actions')->insert(['name' => 'Re-Lease']);
        DB::table('auc_actions')->insert(['name' => 'Sell']);
        DB::table('auc_actions')->insert(['name' => 'Dispose']);
        DB::table('auc_actions')->insert(['name' => 'Retun']);
        DB::table('auc_actions')->insert(['name' => 'Repair']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_actions');
    }
}
