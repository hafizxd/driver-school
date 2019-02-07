<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersActiveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
                'phone' => $faker->e164PhoneNumber,
                'role' => 0,
                'avatar' => '-',
                'address' => $faker->streetAddress,
            ]);
        }

    }
}
