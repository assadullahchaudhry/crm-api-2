<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_prospects', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name');
            $table->string('contacts')->nullable();
            $table->string('group')->nullable();
            $table->string('monthForecast', 30)->nullable();
            $table->timestamp('lastContact')->nullable();
            $table->text('equipmentDetails')->nullable();
            $table->boolean('audited')->nullable();
            $table->boolean('quoted')->nullable();
            $table->boolean('freeTrial')->nullable();
            $table->boolean('installed')->nullable();
            $table->boolean('submitted')->nullable();
            $table->string('nextAction', 50)->nullable();
            $table->double('close')->nullable();
            $table->string('creditStatus', 30)->nullable();
            $table->text('creditNotes')->nullable();
            $table->string('appNumber', 100)->nullable();
            $table->string('entityName')->nullable();
            $table->string('tid')->nullable();
            $table->string('fundingMethod')->nullable();
            $table->integer('pricingLease')->unsigned()->nullable();
            $table->integer('pricingRecurring')->unsigned()->nullable();
            $table->integer('locations')->unsigned()->nullable();
            $table->double('rate')->nullable();
            $table->double('dealValue')->nullable();
            $table->double('recurringValue')->nullable();
            $table->string('cashback')->nullable();
            $table->string('buyout')->nullable();
            $table->text('notes')->nullable();
            $table->text('quoteLink')->nullable();
            $table->string('leadSourceId', 50)->nullable();
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('email', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('cell', 30)->nullable();
            $table->string('regionalFirstName', 50)->nullable();
            $table->string('regionalLastName', 50)->nullable();
            $table->string('regionalEmail', 100)->nullable();
            $table->string('regionalCell', 30)->nullable();
            $table->string('doFirstName', 50)->nullable();
            $table->string('doLastName', 50)->nullable();
            $table->string('doEmail', 100)->nullable();
            $table->string('doCell', 30)->nullable();
            $table->string('ownerName', 70)->nullable();
            $table->string('ownerEmail', 100)->nullable();
            $table->string('ownerPhone')->nullable();
            $table->string('billingFirstName', 50)->nullable();
            $table->string('billingLastName', 50)->nullable();
            $table->string('billingEmail', 100)->nullable();
            $table->string('billingPhone', 30)->nullable();
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
        Schema::dropIfExists('auc_prospects');
    }
}
