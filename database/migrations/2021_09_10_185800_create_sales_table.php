<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('package_id')->unsigned();
            $table->bigInteger('marketing_id')->unsigned();
            $table->enum('paid_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('paid_img')->nullable();
            $table->dateTimeTz('paid_at')->nullable();
            $table->enum('confirm_status', ['unconfirmed', 'confirmed'])->default('unconfirmed');
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
        Schema::dropIfExists('sales');
    }
}
