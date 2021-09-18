<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucProspectAuditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_prospect_auditors', function (Blueprint $table) {
            $table->id();
            $table->string('auditorId', 50)->default(null);
            $table->string('prospectId', 50)->default(null);
            $table->timestamps();

            $table->foreign('auditorId')->references('id')->on('auc_users')->onDelete('SET NULL');
            $table->foreign('prospectId')->references('id')->on('auc_prospects')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_prospect_auditors');
    }
}
