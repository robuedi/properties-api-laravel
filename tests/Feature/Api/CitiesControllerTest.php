<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use App\Models\User;
use Tests\TestCase;

class CitiesControllerTest  extends TestCase
{
    use RefreshDatabase;

      
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=CountrySeeder');
        $this->artisan('db:seed --class=CitySeeder');
    }

    public function testIndexWorks(): void
    {
        $this->json('get', 'api/v1/cities')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'country_id'
                    ]
                ]
            ]
        );
    }

    public function testIndexFieldsFilterWorks(): void
    {
        $this->json('get', 'api/v1/cities?fields[cities]=name&filter[name]=London')
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            [
                'data' => [
                    [
                        'name' => 'London'
                    ]
                ]
            ]
        );
    }
}
