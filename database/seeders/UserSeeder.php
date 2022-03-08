<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithFaker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()
            ->create([
                'email' => 'superuser@email.com',
                'password' => Hash::make('abc123'),
            ]);

        UserAddress::factory()
            ->create(['user_id' => $user->id]);
    }
}
