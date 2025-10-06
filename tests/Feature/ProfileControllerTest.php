<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_profile_page()
    {
        $this->get(route('user.profile'))
             ->assertRedirect(route('user.login'));
    }

    /** @test */
    public function authenticated_user_can_view_profile_page()
    {
        $this->actingAs($this->user)
             ->get(route('user.profile'))
             ->assertOk()
             ->assertViewIs('user.profile')
             ->assertViewHas('user', $this->user)
             ->assertViewHas('stats')
             ->assertViewHas('recentOrders');
    }

    /** @test */
    public function authenticated_user_can_update_profile_information()
    {
        $this->actingAs($this->user);

        $updatedData = [
            'name' => 'Updated Name',
            'phone' => '1234567890',
            'pincode' => '123456',
            'state' => 'New State',
            'city' => 'New City',
            'landmark' => 'New Landmark',
            'locality' => 'New Locality',
            'address' => 'New Address Line 1',
        ];

        $this->post(route('user.profile.update'), $updatedData)
             ->assertRedirect(route('user.profile'))
             ->assertSessionHasNoErrors()
             ->assertSessionHas('success', 'Address updated successfully!');

        $this->user->refresh();
        $this->assertEquals('Updated Name', $this->user->name);
        $this->assertEquals('1234567890', $this->user->phone);
        $this->assertEquals('New Address Line 1', $this->user->address);
    }

    /** @test */
    public function authenticated_user_can_update_profile_information_via_ajax()
    {
        $this->actingAs($this->user);

        $updatedData = [
            'name' => 'Updated Name AJAX',
            'phone' => '0987654321',
            'pincode' => '654321',
            'state' => 'AJAX State',
            'city' => 'AJAX City',
            'landmark' => 'AJAX Landmark',
            'locality' => 'AJAX Locality',
            'address' => 'AJAX Address Line 1',
        ];

        $this->postJson(route('user.profile.update'), $updatedData)
             ->assertOk()
             ->assertJson([
                 'success' => true,
                 'message' => 'Address updated successfully!'
             ]);

        $this->user->refresh();
        $this->assertEquals('Updated Name AJAX', $this->user->name);
        $this->assertEquals('0987654321', $this->user->phone);
        $this->assertEquals('AJAX Address Line 1', $this->user->address);
    }

    /** @test */
    public function authenticated_user_cannot_update_profile_with_invalid_data()
    {
        $this->actingAs($this->user);

        $invalidData = [
            'name' => '',
            'phone' => '',
            'pincode' => '',
            'state' => '',
            'city' => '',
            'landmark' => '',
            'locality' => '',
            'address' => '',
        ];

        $this->post(route('user.profile.update'), $invalidData)
             ->assertSessionHasErrors([
                 'name',
                 'phone',
                 'pincode',
                 'state',
                 'city',
                 'landmark',
                 'locality',
                 'address',
             ]);
    }

    /** @test */
    public function authenticated_user_can_update_password()
    {
        $this->actingAs($this->user);

        $newPassword = 'new_password_123';

        $this->post(route('user.profile.update.password'), [
            'current_password' => 'password',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])
             ->assertRedirect(route('user.profile'))
             ->assertSessionHasNoErrors()
             ->assertSessionHas('success', 'Password updated successfully!');

        $this->assertTrue(Hash::check($newPassword, $this->user->fresh()->password));
    }

    /** @test */
    public function authenticated_user_cannot_update_password_with_incorrect_current_password()
    {
        $this->actingAs($this->user);

        $newPassword = 'new_password_123';

        $this->post(route('user.profile.update.password'), [
            'current_password' => 'wrong_password',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])
             ->assertSessionHasErrors(['current_password']);

        $this->assertFalse(Hash::check($newPassword, $this->user->fresh()->password));
    }

    /** @test */
    public function authenticated_user_cannot_update_password_without_confirmation()
    {
        $this->actingAs($this->user);

        $newPassword = 'new_password_123';

        $this->post(route('user.profile.update.password'), [
            'current_password' => 'password',
            'password' => $newPassword,
            'password_confirmation' => 'mismatch',
        ])
             ->assertSessionHasErrors(['password']);

        $this->assertFalse(Hash::check($newPassword, $this->user->fresh()->password));
    }
}