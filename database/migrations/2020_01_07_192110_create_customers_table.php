<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->bigInteger('user_id')->unsigned();
           // $table->foreign('user_id')->references('id')->on('users'); 
            $table->string('nic',10)->unique();
            $table->string('telephone_no',15);           
            $table->string('address');
            $table->double('longitude');
            $table->double('latitude');
            $table->bigInteger('status_id')->nullable();
           // $table->foreign('status_id')->references('id')->on('statuses');
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
        Schema::dropIfExists('customers');
    }
}
