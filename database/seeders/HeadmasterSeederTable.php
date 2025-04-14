<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HeadmasterSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Headmaster',
            'email' => 'headmaster@example.com',
            'password' => Hash::make('123456789'),
            'role' => 'headmaster',
        ]);
    }
}
