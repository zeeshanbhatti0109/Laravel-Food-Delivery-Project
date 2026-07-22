<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$cities = City::pluck('id'); 
 
        return [ 
            'city_id' => $cities->random(), 
            'name'    => fake()->company(), 
            'address' => fake()->address(), 
        ]; 
    }
}
