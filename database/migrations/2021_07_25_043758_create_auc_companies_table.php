<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_companies', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name')->nullable();
            $table->string('group')->nullable();
            $table->string('firstName', 50);
            $table->string('lastName', 50)->nullable();
            $table->string('omEmail', 100)->unique()->nullable();
            $table->string('officePhone', 30)->nullable();
            $table->string('addressLine1')->nullable();
            $table->string('addressLine2')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('postalCode', 50)->nullable();
            $table->string('countryCode', 5)->nullable();
            $table->string('regionalFirstName', 50)->nullable();
            $table->string('regionalLastName', 50)->nullable();
            $table->string('regionalEmail', 100)->nullable();
            $table->string('regionalCell', 30)->nullable();
            $table->string('doFirstName', 50)->nullable();
            $table->string('doLastName', 50)->nullable();
            $table->string('doEmail', 100)->nullable();
            $table->string('doCell', 30)->nullable();
            $table->string('billingContacts')->nullable();
            $table->string('billingEmail', 100)->nullable();
            $table->string('billingPhone', 30)->nullable();
            $table->string('ownerName', 70)->nullable();
            $table->string('itContactFirstName', 50)->nullable();
            $table->string('itContactLastName', 50)->nullable();
            $table->string('itSupportPhone', 30)->nullable();
            $table->string('itSupportEmail', 100)->nullable();
            $table->string('preferredSuppliesShippingService', 100)->nullable();
            $table->string('shipstationUsername', 100)->nullable();
            $table->string('fullAddress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_companies');
    }
}
