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
            'name'     => 'q1a2z3q1',
            'email'    => 'q1a2z3q1@yopmail.com',
            'password' => Hash::make( 'q1a2z3q1' ),
        ] );
    }
}
