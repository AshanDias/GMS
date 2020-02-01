<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('area_id')->default(0);
            $table->integer('vehicle_type_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->string('description')->default(0);
            $table->string('tele_no')->default(0);            
            $table->double('longitude');
            $table->double('latitude');
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->text('address_3')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->string('request_date')->nullable();
            $table->string('request_time')->nullable();
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
        Schema::dropIfExists('customer_requests');
    }
}
