<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for login tests
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    /** @test */
    public function user_can_view_login_form()
    {
        $this->get(route('user.login'))
             ->assertOk()
             ->assertViewIs('user.auth.login');
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $this->post(route('user.login.post'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ])
             ->assertRedirect(route('user.home'));

        $this->assertAuthenticated('web');
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $this->post(route('user.login.post'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ])
             ->assertSessionHasErrors('email');

        $this->assertGuest('web');
    }

    /** @test */
    public function user_can_login_with_valid_credentials_via_ajax()
    {
        $this->postJson(route('user.login.post'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ])
             ->assertOk()
             ->assertJson([
                 'success' => true,
                 'message' => 'Login successful! Redirecting...',
                 'redirect' => route('user.home')
             ]);

        $this->assertAuthenticated('web');
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials_via_ajax()
    {
        $this->postJson(route('user.login.post'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ])
             ->assertStatus(422)
             ->assertJsonValidationErrors('email');

        $this->assertGuest('web');
    }

    /** @test */
    public function user_can_view_registration_form()
    {
        $this->get(route('user.register'))
             ->assertOk()
             ->assertViewIs('user.auth.register');
    }

    /** @test */
    public function user_can_register_with_valid_data()
    {
        $this->post(route('user.register.post'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
             ->assertRedirect(route('user.home'));

        $this->assertAuthenticated('web');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => 'New User',
            'role' => 'user',
        ]);
    }

    /** @test */
    public function user_cannot_register_with_invalid_data()
    {
        $this->post(route('user.register.post'), [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ])
             ->assertSessionHasErrors([
                 'name',
                 'email',
                 'password',
             ]);

        $this->assertGuest('web');
    }

    /** @test */
    public function user_cannot_register_with_existing_email()
    {
        $this->post(route('user.register.post'), [
            'name' => 'Another User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
             ->assertSessionHasErrors('email');

        $this->assertGuest('web');
    }

    /** @test */
    public function user_can_register_with_valid_data_via_ajax()
    {
        $this->postJson(route('user.register.post'), [
            'name' => 'New User Ajax',
            'email' => 'newuserajax@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
             ->assertOk()
             ->assertJson([
                 'success' => true,
                 'message' => 'Account created successfully! Redirecting...',
                 'redirect' => route('user.home')
             ]);

        $this->assertAuthenticated('web');
        $this->assertDatabaseHas('users', [
            'email' => 'newuserajax@example.com',
            'name' => 'New User Ajax',
            'role' => 'user',
        ]);
    }

    /** @test */
    public function user_cannot_register_with_invalid_data_via_ajax()
    {
        $this->postJson(route('user.register.post'), [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ])
             ->assertStatus(422)
             ->assertJsonValidationErrors([
                 'name',
                 'email',
                 'password',
             ]);

        $this->assertGuest('web');
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('user.logout'))
             ->assertRedirect('/');

        $this->assertGuest('web');
    }
}