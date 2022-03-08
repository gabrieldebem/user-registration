<?php

namespace Database\Factories;

use App\Enums\State;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends Factory
 */
class UserAddressFactory extends Factory
{
    use WithFaker;
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'zipcode' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'number' => $this->faker->randomNumber(2),
            'complement' => null,
            'district' => 'fake district',
            'city' => $this->faker->city(),
            'state' => $this->faker->randomElement(State::values()),
        ];
    }
}
