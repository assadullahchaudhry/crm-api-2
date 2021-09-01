<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAucUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auc_users', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('avatar')->nullable();

            $table->string('gender', 7)->nullable();
            $table->boolean('isActive')->default(false);
            $table->bigInteger('roleId')->unsigned();
            $table->string('address')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('roleId')->references('id')->on('auc_roles');
        });

        DB::table('auc_users')->insert([
            'id' => getRandomId(),
            'firstName' => 'Assad Ullah',
            'lastName' => 'Ch',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('123456789'),
            'roleId' => 1,

            'gender' => 'Male',
            'isActive' => true
        ]);

        DB::table('auc_users')->insert([
            'id' => getRandomId(),
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'user@example.com',
            'password' => bcrypt('123456789'),
            'roleId' => 3,

            'gender' => 'Male',
            'isActive' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auc_users');
    }
}
