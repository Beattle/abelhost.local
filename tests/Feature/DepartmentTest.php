<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use  WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDepartmentCreate()
    {
        $logo = UploadedFile::fake()->image('logo.jpg',640,480);
        $user = User::where('name', '=', 'admin')->first();
        $response = $this->actingAs($user)->followingRedirects()
            ->postJson('/departments',[
                'name' => $this->faker->unique()->jobTitle,
                'description' => $this->faker->realText(),
                'logo' => $logo
            ]);

        $response->assertInertia('Departments/Form');
        $response->assertInertiaHas('department.id');
    }
}
