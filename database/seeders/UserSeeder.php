<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{




    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pop Gheorghe',
            'email' => 'pop_gheorghe20@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'phone_number' => "0740450650",
            'terms_accepted_at' => Carbon::now(),
            'accepted_terms_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Maria Iordache',
            'email' => 'mariaio@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'phone_number' => "0740450650",
            'terms_accepted_at' => Carbon::now(),
            'accepted_terms_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'GEO dude',
            'email' => 'geodude_pokemon@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'phone_number' => "0740450650",
            'terms_accepted_at' => Carbon::now(),
            'accepted_terms_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Laura Voda',
            'email' => 'lvoda@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'phone_number' => "0740450650",
            'terms_accepted_at' => Carbon::now(),
            'accepted_terms_id' => 1
        ]);
    }
}
