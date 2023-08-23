<?php

namespace Tests\Feature\Api;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPropertiesControllerTest extends TestCase
{
    use RefreshDatabase;

      
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_user_can_create_property(): void
    {
        $user = User::factory()->create();
        $property = Property::factory()->make(['owner_id' => $user->id]);
        $response = $this->actingAs($user)
                    ->postJson('api/v1/user/'.$user->id.'/properties', $property->toArray());
                  
        $response->assertStatus(201);
    }

    public function test_user_cant_create_someone_else_property(): void
    {
      
    }

    public function test_user_can_edit_his_property(): void
    {
      
    }

    public function test_user_cant_edit_someone_else_property(): void
    {
      
    }

    public function test_user_can_see_his_property(): void
    {
      
    }

    public function test_user_cant_see_someone_else_property(): void
    {
      
    }

    public function test_user_can_delete_his_property(): void
    {
      
    }

    public function test_user_cant_delete_someone_else_property(): void
    {
      
    }


    public function test_user_can_see_all_his_properties(): void
    {
      
    }

    public function test_user_cant_see_someone_else_all_properties(): void
    {
      
    }
}
