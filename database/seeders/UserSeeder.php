<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        $user->assignRole('admin');

        // 2
        $user = User::create([
            'name' => 'Irfan Siregar',
            'email' => 'IrfanSiregar@gmail.com',
            'password' =>  Hash::make('irfansiregar'),
        ]);

        $user->assignRole('director');

        // 3
        $user = User::create([
            'name' => 'Ignatia Hutagalung',
            'email' => 'IgnatiaHutagalung@gmail.com',
            'password' =>  Hash::make('Ignatiahutagalung'),
        ]);

        $user->assignRole('division');

        // 4
        $user = User::create([
            'name' => 'Dwita Sihombing',
            'email' => 'DwitaSihombing@gmail.com',
            'password' =>  Hash::make('DwitaSihombing'),
        ]);

        $user->assignRole('division');
    }
}
