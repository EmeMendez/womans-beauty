<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout()
    {
        $user       = User::factory()->create();
        $token      = $user->createToken('userApiToken')->plainTextToken;
        $response   = $this->withHeaders(['Authorization' => "Bearer $token"])
                           ->postJson('/api/v1/logout');
        $response->assertStatus(204);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => 'App/Models/User',
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_logout_no_authorized()
    {
        $user   = User::factory()->create();
        $response = $this->postJson('/api/v1/logout',);
        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }
}
