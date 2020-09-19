<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
                'address' => 'Palao',
                'contact' => '12356'
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
                'address' => 'Opol',
                'contact' => '12356'
            ],
            [
                'name' => 'Conor Mac',
                'email' => 'conor@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
                'address' => 'Tibanga',
                'contact' => '12356'
            ],  
            [
                'name' => 'Shawn Michaels',
                'email' => 'shawn@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
                'address' => 'Tambo',
                'contact' => '12356'
            ],
            [
                'name' => 'Rey Pumba',
                'email' => 'rey@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
                'address' => 'CDO',
                'contact' => '12356'
            ],
        ]);
    }
}
