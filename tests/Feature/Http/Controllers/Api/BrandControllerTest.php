<?php

namespace Http\Controllers\Api;

use App\Http\Controllers\Api\BrandController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Brand;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function conditionalSetUp(){
        parent::setUp();
        Sanctum::actingAs(
          User::factory()->create()
        );
    }

    public function test_index()
    {
        $this->conditionalSetUp();

        Brand::factory(3)->create();
        $response = $this->getJson('/api/v1/brands');
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
        Brand::factory(3)->create();
        $response = $this->getJson('/api/v1/brands');
        $response->assertStatus(401);
    }

    public function test_show()
    {
        $this->conditionalSetUp();
        $brand = Brand::factory()->create();
        $response = $this->getJson("/api/v1/brands/$brand->id");
        $response->status(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'status',
                'created_at',
                'updated_at'
            ]
        ]);
        $response->assertJsonFragment([
            'name' => $brand->name
        ]);
    }

    public function test_show_resource_not_found()
    {
        $this->conditionalSetUp();
        $brand = Brand::factory()->make(['id' => $this->faker->ean8()]);
        $response = $this->getJson("/api/v1/brands/$brand->id");
        $response->status(404);
        $response->assertJsonFragment([
            'message' => 'Recurso no encontrado'
        ]);
    }

    public function test_show_no_authorized()
    {
        $brand = Brand::factory()->create();
        $response = $this->getJson("/api/v1/brands/$brand->id");
        $response->status(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function test_store()
    {
        $this->conditionalSetUp();
        $brand = Brand::factory()->make();

        $data = [
            'name' => $brand->name
        ];

        $response = $this->postJson('/api/v1/brands', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'status',
                'created_at',
                'updated_at'
            ]
        ]);
        $this->assertDatabaseHas('brands', [
            'name' => $brand->name
        ]);
        $response->assertJsonFragment([
            'name' => $brand->name
        ]);
    }

    public function test_store_name_required()
    {
        $this->conditionalSetUp();
        $data = [];

        $response = $this->postJson('/api/v1/brands', $data);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'El nombre es requerido'
        ]);
    }

    public function test_store_no_authorized()
    {
        $brand = Brand::factory()->make();
        $data = [
            'name' => $brand->name
        ];

        $response = $this->postJson('/api/v1/brands', $data);
        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function test_update()
    {
        $this->conditionalSetUp();
        $brand = Brand::factory()->create();

        $data = [
            'name' => $this->faker->word
        ];

        $response = $this->patchJson("/api/v1/brands/$brand->id", $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'status',
                'created_at',
                'updated_at'
            ]
        ]);
        $this->assertDatabaseHas('brands', [
            'name' => $data['name']
        ]);
        $response->assertJsonFragment([
            'name' => $data['name']
        ]);
    }

    public function test_update_name_required()
    {
        $this->conditionalSetUp();
        $brand = Brand::factory()->create();

        $data = [];

        $response = $this->patchJson("/api/v1/brands/$brand->id", $data);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'name' => ['El nombre es requerido']
        ]);
    }

    public function test_update_resource_not_found()
    {
        $this->conditionalSetUp();
        $brand = Brand::factory()->make(['id' => $this->faker->ean8()]);

        $data = [
            'name' => $this->faker->word
        ];

        $response = $this->patchJson("/api/v1/brands/$brand->id", $data);
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'message' => 'Recurso no encontrado'
        ]);
    }

    public function test_update_no_authorized()
    {
        $brand = Brand::factory()->create();

        $data = [
            'name' => $this->faker->word
        ];

        $response = $this->patchJson("/api/v1/brands/$brand->id", $data);
        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.'
        ]);
    }
}
