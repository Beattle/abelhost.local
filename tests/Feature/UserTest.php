<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * test for creating user by admin
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user = User::where('name','=','admin')->first();
        $response = $this->actingAs($user)->followingRedirects()
        ->postJson('/users',
            [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);

        $response->assertInertiaHas('edit_user.id');

    }

    public function testCreateNotAuth(){
        $response = $this->postJson('/users',
            [
                'name' => $this->faker->name,
                'Email' => $this->faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);

        $response->assertStatus(401);
    }
}
