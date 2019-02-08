<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('driver_id')->unsigned();
            $table->tinyInteger('active')->default(0);
            $table->string('plan');
            $table->string('price')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('note')->nullable();
            $table->text('reason')->nullable();
            $table->string('destination')->nullable();
            $table->string('pickup_point')->nullable();
            $table->text('start_date');
            $table->text('end_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
