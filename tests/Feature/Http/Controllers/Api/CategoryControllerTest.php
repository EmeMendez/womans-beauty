<?php

namespace Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function conditionalSetUp(): void
    {
        parent::setUp();

        Sanctum::ActingAs(
            User::factory()->create()
        );
    }

    public function test_index()
    {
        $this->conditionalSetUp();
        Category::factory(3)->create();
        $response = $this->getJson('/api/v1/categories');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertJsonCount(3, 'data');
        $response->assertStatus(200);
    }
    public function test_index_no_authorized()
    {
        Category::factory(3)->create();
        $response = $this->getJson('/api/v1/categories');
        $response->assertStatus(401);
    }
}
