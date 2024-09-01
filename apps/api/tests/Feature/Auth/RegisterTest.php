<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_new_users_can_register(): void
    {
        $response = $this->postJson(route('api.auth.register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertNoContent();

        $this->assertAuthenticated();
        $this->assertDatabaseCount(User::class, 1);
    }

    public function test_cannot_register_email_twice(): void
    {
        $email = 'test@example.com';

        User::factory()->create([
            'name' => 'User 1',
            'email' => $email,
            'password' => 'password',
        ]);

        $response = $this->postJson(route('api.auth.register'), [
            'name' => 'User 2',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertUnprocessable();

        $this->assertGuest();
        $this->assertDatabaseCount(User::class, 1);
    }

    public function test_cannot_register_as_logged_user(): void
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->postJson(route('api.auth.register'), [
            'name' => 'User 5',
            'email' => $user->email,
            'password' => 'other-password',
            'password_confirmation' => 'other-password',
        ]);

        $this->assertDatabaseCount(User::class, 1);
        $response->assertRedirect();
    }
}
