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
            $table->string('phone')->nullable();
            $table->tinyInteger('role')->default(4);
            $table->string('avatar')->nullable();
            $table->string('nopol')->nullable();
            $table->string('tipe_mobil')->nullable();
            $table->tinyInteger('max_penumpang')->nullable();
            $table->tinyInteger('gender_penumpang')->nullable(); //0=campur, 1=laki 2=Perempuan
            $table->string('tujuan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('password');
            $table->text('fcm_token')->nullable();
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
