<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_tasks', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('companyId', 50)->default(null);
            $table->text('description');
            $table->string('status', 10)->default('pending');
            $table->string('createdBy', 50)->nullable();
            $table->string('assignedTo', 50)->nullable();
            $table->timestamp('startDate')->nullable();
            $table->timestamp('dueDate')->nullable();
            $table->timestamps();

            $table->foreign('companyId')->references('id')->on('auc_companies')->onDelete('cascade');
            $table->foreign('createdBy')->references('id')->on('auc_users')->onDelete('set null');
            $table->foreign('assignedTo')->references('id')->on('auc_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_tasks');
    }
}
