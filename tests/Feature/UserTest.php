<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
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
    public function testCanCreateUser()
    {
        $userData = [
            'email' => 'gabriel@sdasd.com',
            'password' => 'gabi123',
            'first_name' => 'gabriel',
            'last_name' => 'roxo',
            'cpf' => '03468918097',
            'rg' => '9113798483',
            'birth_date' => '1999-01-11',
            'phone' => '5133323332',
            'cellphone' => '51993239828',
        ];
        $this->post('/api/users', $userData)
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'email' => 'gabriel@sdasd.com',
            'first_name' => 'gabriel',
            'last_name' => 'roxo',
            'cpf' => '03468918097',
            'rg' => '9113798483',
            'birth_date' => '1999-01-11',
            'phone' => '5133323332',
            'cellphone' => '51993239828',
        ]);
    }

    /** @test */
    public function testCanGetCurrentUser()
    {
        $this->actingAs($this->user)
            ->get('/api/me')
            ->assertSuccessful()
            ->assertJson($this->user->toArray());
    }

    /** @test */
    public function testCantListUsersWithoutSuperUser()
    {
        $this->actingAs($this->user)
            ->get('/api/users')
            ->assertUnauthorized()
            ->assertJsonFragment(['message' => 'Não autorizado.']);
    }

    /** @test */
    public function testCanListUsersWithSuperUser()
    {
        $superUser = User::factory()
            ->create(['email' => 'superuser@email.com']);

        $this->actingAs($superUser)
            ->get('/api/users')
            ->assertSuccessful();
    }

    /** @test */
    public function testCantShowOtherUsersWithoutSuperUser()
    {
        $secondUser = User::factory()
            ->create();

        $this->actingAs($this->user)
            ->get('/api/users/' . $secondUser->id)
            ->assertUnauthorized()
            ->assertJsonFragment(['message' => 'Não autorizado.']);
    }

    /** @test */
    public function testCanShowOtherUsersWithSuperUser()
    {
        $superUser = User::factory()
            ->create(['email' => 'superuser@email.com']);

        $secondUser = User::factory()
            ->create();

        $this->actingAs($superUser)
            ->get('/api/users/' . $secondUser->id)
            ->assertSuccessful()
            ->assertJson($secondUser->toArray());
    }

    /** @test */
    public function testCanUpdateAnUser()
    {
        $userData = [
            'email' => 'gabriel@sdasd.com',
            'first_name' => 'gabriel',
            'last_name' => 'roxo',
            'cpf' => '03468918097',
            'rg' => '9113798483',
            'birth_date' => '1999-01-11',
            'phone' => '5133323332',
            'cellphone' => '51993239828',
        ];
        $this->actingAs($this->user)
            ->put('/api/users', $userData)
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'email' => 'gabriel@sdasd.com',
            'first_name' => 'gabriel',
            'last_name' => 'roxo',
            'cpf' => '03468918097',
            'rg' => '9113798483',
            'birth_date' => '1999-01-11',
            'phone' => '5133323332',
            'cellphone' => '51993239828',
        ]);
    }

    /** @test */
    public function testCanDeleteAnUser()
    {
        $this->actingAs($this->user)
            ->delete('/api/users/')
            ->assertNoContent();

        $this->assertDatabaseMissing('users', $this->user->toArray());
    }
}
