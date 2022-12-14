<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory(100)->create();

        User::factory(1)->create([
            'name' => 'Bevi Teste',
            'email' => 'teste@bevi.com',
            'password' => Hash::make("bevi01"),
        ]);
    }
}
