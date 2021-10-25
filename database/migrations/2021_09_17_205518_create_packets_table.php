<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('description')->nullable();
            $table->bigInteger('price')->unsigned();
            $table->bigInteger('price_promo')->unsigned()->nullable();
            $table->bigInteger('marketing_fee')->unsigned();
            $table->bigInteger('duration')->unsigned();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->string('information')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('packets');
    }
}
