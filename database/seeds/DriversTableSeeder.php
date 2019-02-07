<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Driver;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 100; $i++){
            $driver = new Driver;
            $driver->name = $faker->name;
            $driver->email = $faker->email;
            $driver->nopol = 'AB '.$faker->unixTime . ' ACC';
            $driver->phone = $faker->phoneNumber;
            $driver->tipe_mobil = $faker->userName;

            $driver->password = bcrypt("secret");
            $driver->save();
        }
    }
}
