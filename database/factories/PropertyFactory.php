<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\ListingType;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $listing_type = ListingType::inRandomOrder()->first();

        $listing = [];
        if($listing_type->name === 'sell'){
            $listing = [
                'sell_listing' => [
                    'price' => $this->faker->numberBetween(300_0000, 1_500_000)    
                ]
            ] ; 
        }
        if($listing_type->name === 'rent'){
            $listing = [
                'rent_listing' => [
                    'price_weekly' => $this->faker->numberBetween(300, 1_500),   
                    'price_monthly' => $this->faker->numberBetween(300, 1_500),   
                    'deposit' => $this->faker->numberBetween(300, 1_500),
                    'minimum_tenancy' => $this->faker->numberBetween(1, 12),
                    'pets_allowed' => $this->faker->numberBetween(1, 0),
                ]
            ] ; 
        }

        return [
            'name' => $this->faker->realText(20),
            'owner_id'=> User::factory()->create()->id,
            'property_type_id'=> PropertyType::first()->id,
            'listing_type_id' => $listing_type->id,
            'address' => [
                'city_id'=> City::inRandomOrder()->first()->id,
                'street_name' => $this->faker->streetName(),
                'street_nr' =>  $this->faker->numberBetween(1,300),
                'postcode' => $this->faker->postcode()
            ],
            'description' => $this->faker->text(200),
            'bedrooms'=> $this->faker->numberBetween(1,10),
            'bathrooms' => $this->faker->numberBetween(1, 10),
            ...$listing
        ];
    }
}
