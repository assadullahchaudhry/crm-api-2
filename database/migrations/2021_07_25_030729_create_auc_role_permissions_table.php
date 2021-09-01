<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('roleId')->unsigned();
            $table->bigInteger('permissionId')->unsigned();
            $table->timestamps();

            $table->foreign('roleId')->references('id')->on('auc_roles');
            $table->foreign('permissionId')->references('id')->on('auc_permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_role_permissions');
    }
}
