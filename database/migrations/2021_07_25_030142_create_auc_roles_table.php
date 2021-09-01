<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname', 15);
            $table->string('name', 15);
            $table->timestamps();
        });

        DB::table('auc_roles')->insert([ 'nickname' => 'super-admin', 'name' => 'Super Admin']);
        DB::table('auc_roles')->insert([ 'nickname' => 'admin', 'name' => 'Admin']);
        DB::table('auc_roles')->insert([ 'nickname' => 'employee', 'name' => 'Employee']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_roles');
    }
}
