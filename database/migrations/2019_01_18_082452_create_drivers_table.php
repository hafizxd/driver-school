<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('role')->default(2);
            $table->string('avatar');
            $table->string('tipe_mobil');
            $table->tinyInteger('max_penumpang');
            $table->string('gender_penumpang');
            $table->string('tujuan');
            $table->string('alamat');
            $table->integer('phone');
            $table->string('password');
            $table->text('fcm_token');
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
        Schema::dropIfExists('drivers');
    }
}
