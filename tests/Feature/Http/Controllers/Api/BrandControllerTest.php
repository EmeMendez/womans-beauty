<?php

namespace Http\Controllers\Api;

use App\Http\Controllers\Api\BrandController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Brand;

class BrandControllerTest extends TestCase
{
    use RefreshDatabase;

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
}
