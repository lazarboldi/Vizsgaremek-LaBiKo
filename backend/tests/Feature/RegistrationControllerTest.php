<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_user_with_user_role(): void
    {
        $payload = [
            'name' => 'Teszt Elek',
            'email' => 'teszt.elek@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
            'phone' => '+36701234567',
        ];

        $response = $this->postJson('/api/registration', $payload);

        $response
            ->assertOk()
            ->assertJsonPath('user.email', 'teszt.elek@example.com')
            ->assertJsonPath('user.role', 'user');

        $this->assertDatabaseHas('users', [
            'email' => 'teszt.elek@example.com',
            'role' => 'user',
        ]);
    }

    public function test_registration_requires_matching_password_confirmation(): void
    {
        $this->postJson('/api/registration', [
            'name' => 'Hibas Jelszo',
            'email' => 'hibas@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'EltérőJelszo123',
            'phone' => '+36701112222',
        ])->assertUnprocessable()
          ->assertJsonValidationErrors(['password']);
    }
}
