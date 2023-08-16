<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use App\Models\User;
use Tests\TestCase;

class CountriesControllerTest  extends TestCase
{
    use RefreshDatabase;

      
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=CountrySeeder');
    }

    public function testIndexWorks(): void
    {
        $this->json('get', 'api/v1/countries')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ]
        );
    }

    public function testIndexFieldsFilterWorks(): void
    {
        $this->json('get', 'api/v1/countries?fields[countries]=name&filter[name]=UK')
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(
            [
                'data' => [
                    [
                        'name' => 'UK'
                    ]
                ]
            ]
        );
    }
}
