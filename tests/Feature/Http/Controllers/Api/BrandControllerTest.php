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
}
