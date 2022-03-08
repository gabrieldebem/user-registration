<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'cpf' => 00000000000,
            'rg' => 9999999999,
            'birth_date' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'phone' => 5133333333,
            'cellphone' => 51999999999,
        ];
    }
}
