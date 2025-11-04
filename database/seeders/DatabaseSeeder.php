<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'        => 'Админ',
            'second_name' => '', // укажи если поле обязательно
            'surname'     => '',
            'email'       => 'admin@site.ru',
            'phone'       => '',
            'password'    => Hash::make('admin123'),
            'role'        => 'admin', // или role_id если роль id
        ]);
    }
}
