<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i <= 100;$i++){
            $user = new User;
            $user->name = str_random(10);
            $user->email = str_random(10) . '@gmail.com';
            $user->address = $faker->address;
            $user->phone = $faker->phoneNumber;
            $user->password = bcrypt('secret');
            $user->save();
        }

    }
}
