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
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('packet_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('marketing_id')->unsigned();
            $table->foreign('marketing_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('price')->unsigned();
            $table->bigInteger('marketing_fee')->unsigned();
            $table->bigInteger('unique_code')->unsigned();
            $table->string('image')->nullable();
            $table->dateTimeTz('confirmed_at')->nullable();
            $table->dateTimeTz('expired_at')->nullable();
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
