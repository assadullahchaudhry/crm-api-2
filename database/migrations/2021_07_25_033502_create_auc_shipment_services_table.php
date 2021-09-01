<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucShipmentServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_shipment_services', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 150);
            $table->timestamps();
        });

        $id = 999;

        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'Workflow Delivery']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'Vendor Delivery']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx Ground®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx Home Delivery®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx 2Day®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx 2Day® A.M.']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx Express Saver®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx Standard Overnight®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx Priority Overnight®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx First Overnight®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx 1Day® Freight']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx 2Day® Freight']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx 3Day® Freight']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'FedEx First Overnight® Freight']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS First Class Mail']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS Media Mail']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS Parcel Select Ground']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS Priority Mail']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS Priority Mail Express']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS First Class Mail Intl']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS Priority Mail Intl']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'USPS Priority Mail Express Intl']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS® Ground']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS 3 Day Select®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS 2nd Day Air®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Worldwide Express®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Next Day Air Saver®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Next Day Air®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Worldwide Expedited®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Worldwide Saver®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Standard®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Next Day Air® Early']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS 2nd Day Air AM®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Worldwide Express Plus®']);
        DB::table('auc_shipment_services')->insert(['id' => ($id++), 'name' => 'UPS Ground® (International)']);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_shipment_services');
    }
}
