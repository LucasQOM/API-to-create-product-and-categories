<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultAdmin();
    }
    private function createDefaultAdmin(){
        $token = Str::random(60);
        $admin = [
            'name' => 'Administrador Padrão',
            'email' => 'admin@admin.com.br',
            'password' => Hash::make('password'),
        ];

        User::create($admin);
    }
}
