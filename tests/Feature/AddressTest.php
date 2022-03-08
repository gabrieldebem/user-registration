<?php

namespace Tests\Feature;

use App\Enums\State;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function testCanListUserAddresses()
    {
        $address = UserAddress::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user)
            ->get('/api/users/address')
            ->assertSuccessful()
            ->assertJsonFragment($address->toArray());
    }

    /** @test */
    public function testCantListAddressesNotAssociateToTheCurrentUser()
    {
        $address = UserAddress::factory()->create();
        $this->actingAs($this->user)
            ->get('/api/users/address')
            ->assertSuccessful()
            ->assertJsonMissing($address->toArray());
    }

    /** @test */
    public function testCanGetUserAddresses()
    {
        $address = UserAddress::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user)
            ->get('/api/users/address/' . $address->id)
            ->assertSuccessful()
            ->assertJson($address->toArray());
    }

    /** @test */
    public function testCanCreateUserAddresses()
    {
        $addressData = [
            'zipcode' => $this->faker->postcode(),
            'address' => $this->faker->text(20),
            'number' => 123,
            'complement' => null,
            'district' => $this->faker->text(20),
            'city' => $this->faker->text(20),
            'state' => $this->faker->randomElement(State::values()),
        ];
        $this->actingAs($this->user)
            ->post('/api/users/address', $addressData)
            ->assertSuccessful()
            ->assertJsonFragment($addressData);

        $this->assertDatabaseHas('user_addresses', $addressData);
    }

    /** @test */
    public function testCanUpdateUserAddressesWhenAlreadyHasOne()
    {
        UserAddress::factory()->create(['user_id' => $this->user->id]);

        $addressData = [
            'zipcode' => $this->faker->postcode(),
            'address' => $this->faker->text(20),
            'number' => 123,
            'complement' => null,
            'district' => $this->faker->text(20),
            'city' => $this->faker->text(20),
            'state' => $this->faker->randomElement(State::values()),
        ];
        $this->actingAs($this->user)
            ->put("/api/users/address/{$this->user->address->id}", $addressData)
            ->assertSuccessful()
            ->assertJsonFragment($addressData);

        $this->assertDatabaseHas('user_addresses', $addressData);
    }

    /** @test */
    public function testCanDeleteAnUserAddress()
    {
        $address = UserAddress::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user)
            ->delete('/api/users/address/' . $address->id)
            ->assertNoContent();

        $this->assertDatabaseMissing('user_addresses', $address->toArray());
    }
}
