<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'users' )->insert( [
            'name'     => 'w1s2x3w1',
            'email'    => 'w1s2x3w1@yopmail.com',
            'password' => Hash::make( 'w1s2x3w1' ),
        ] );
    }
}
