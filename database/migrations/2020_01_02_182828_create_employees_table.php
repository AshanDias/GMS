<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',50);
            $table->string('last_name',50);
            //$table->bigInteger('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('users'); 
            $table->string('nic',10)->unique();
            $table->string('telephone_no',15);
            $table->bigInteger('employee_type_id')->unsigned();
            $table->foreign('employee_type_id')->references('id')->on('user_types');
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->tinyInteger('have_group')->default(0);
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
        Schema::dropIfExists('employees');
    }
}
