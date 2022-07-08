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
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function test_show()
    {
        $this->conditionalSetUp();
        $category = Category::factory()->create();
        $response = $this->getJson("/api/v1/categories/$category->id");
        $response->assertStatus(200);
        $response->assertJsonStructure([
                'data' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at'
                    ]
                ]
        );
        $response->assertJsonFragment([
            'name' => $category->name
        ]);
    }

    public function test_show_not_found()
    {
        $this->conditionalSetUp();
        $category = Category::factory()->make(['id' => 1000]);
        $response = $this->getJson("/api/v1/categories/$category->id");
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'Recurso no encontrado'
        ]);
    }

    public function test_show_no_authorized()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("/api/v1/categories/$category->id");
        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }


    public function test_store()
    {
        $this->conditionalSetUp();

        $category = Category::factory()->make();
        $data = [
          'name' => $category->name
        ];

        $response = $this->postJson('/api/v1/categories', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at',
                'updated_at'
             ]
        ]);
        $response->assertJsonFragment([
            'name' => $category->name
        ]);
    }

    public function test_store_name_required()
    {
        $this->conditionalSetUp();
        $data = [];

        $response = $this->postJson('/api/v1/categories', $data);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'name' => ['El nombre es requerido']
        ]);
    }

    public function test_store_no_authorized()
    {
        $category = Category::factory()->make();
        $data = [
            'name' => $category->name
        ];

        $response = $this->postJson('/api/v1/categories', $data);
        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }



}
