<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'name' => 'Sheena Ocon', 
            'email' => 'oconsheen@@gmail.com',
            'password' => Hash::make('sheen071')
        ]);
    }

    // e run ang "php artisan db:seed --class=UsersTableSeeder" para ma insert na sa database
}