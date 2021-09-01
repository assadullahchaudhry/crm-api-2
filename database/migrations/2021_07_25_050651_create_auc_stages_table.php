<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_stages', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        DB::table('auc_stages')->insert(['name' => 'Lead']);
        DB::table('auc_stages')->insert(['name' => 'Initial Contract']);
        DB::table('auc_stages')->insert(['name' => 'Discovery Meeting']);
        DB::table('auc_stages')->insert(['name' => 'Print Audit']);
        DB::table('auc_stages')->insert(['name' => 'Quoted']);
        DB::table('auc_stages')->insert(['name' => 'Follow Up']);
        DB::table('auc_stages')->insert(['name' => 'Free Trial']);
        DB::table('auc_stages')->insert(['name' => 'Gone Cold']);
        DB::table('auc_stages')->insert(['name' => 'Closed - Won']);
        DB::table('auc_stages')->insert(['name' => 'Closed - Lost']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_stages');
    }
}
