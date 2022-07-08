<?php

namespace Http\Controllers\Api;

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, withFaker;

    public function test_login()
    {
        $user = User::factory()->create();

        $credentials = [
            'email'         => $user->email,
            'password'      => 'password',
            'device_name'   => $this->faker->userAgent

        ];
        $response = $this->postJson('/api/v1/login', $credentials);
        $response->assertJsonStructure(["token"]);
        $response->assertStatus(200);
    }

    public function test_login_fail()
    {
        $user = User::factory()->make();

        $credentials = [
            'email'         => $user->email,
            'password'      => 'password',
            'device_name'   => $this->faker->userAgent

        ];
        $response = $this->postJson('/api/v1/login', $credentials);
        $response->assertJsonStructure([
            "message",
            "errors",
            ]
        );
        $response->assertJsonFragment([
            'email' => ['Estas credenciales no coinciden con nuestros registros']
        ]);
        $response->assertStatus(422);
    }

    public function test_login_email_required()
    {
        $user = User::factory()->make();

        $credentials = [
            'email'         => '',
            'password'      => 'password',
            'device_name'   => $this->faker->userAgent

        ];
        $response = $this->postJson('/api/v1/login', $credentials);
        $response->assertJsonStructure([
                "message",
                "errors",
            ]
        );
        $response->assertJsonFragment([
            'email' => ['El correo electrónico es requerido']
        ]);
        $response->assertStatus(422);
    }

    public function test_login_password_required()
    {
        $user = User::factory()->create();

        $credentials = [
            'email'         => $user->email,
            'password'      => '',
            'device_name'   => $this->faker->userAgent

        ];
        $response = $this->postJson('/api/v1/login', $credentials);
        $response->assertJsonStructure([
                "message",
                "errors",
            ]
        );
        $response->assertJsonFragment([
            'password' => ['La contraseña es requerida']
        ]);
        $response->assertStatus(422);
    }

    public function test_login_email_format_is_invalid()
    {
        $user = User::factory()->make(['email' => 'incorectFormat']);

        $credentials = [
            'email'         => $user->email,
            'password'      => 'password',
            'device_name'   => $this->faker->userAgent

        ];
        $response = $this->postJson('/api/v1/login', $credentials);
        $response->assertJsonStructure([
                "message",
                "errors",
            ]
        );
        $response->assertJsonFragment([
            'email' => ['El formato del correo electrónico no es válido']
        ]);
        $response->assertStatus(422);
    }

    public function test_login_email_doesnt_exist()
    {
        $user = User::factory()->make();

        $credentials = [
            'email'         => $user->email,
            'password'      => 'password',
            'device_name'   => $this->faker->userAgent

        ];
        $response = $this->postJson('/api/v1/login', $credentials);
        $response->assertJsonStructure([
                "message",
                "errors",
            ]
        );
        $response->assertJsonFragment([
            'email' => ['Estas credenciales no coinciden con nuestros registros']
        ]);
        $response->assertStatus(422);
    }
}
