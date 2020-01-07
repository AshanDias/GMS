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
            $table->bigInteger('employee_type_id')->unsigned();
            $table->foreign('employee_type_id')->references('id')->on('employee_types');
            $table->string('nic',10)->unique();
            $table->string('telephone_no',15);
            $table->bigInteger('employee_group_id')->unsigned();
            $table->foreign('employee_group_id')->references('id')->on('employee_groups');
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
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
