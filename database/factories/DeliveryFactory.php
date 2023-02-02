<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->value('id'),
            'from_postcode' => Str::substrReplace(fake('pt_BR')->postcode(), '.', 2, 0),
            'to_postcode' => Str::substrReplace(fake('pt_BR')->postcode(), '.', 2, 0),
            'from_weight' => fake()->randomFloat(2, 0.01, 1000),
            'to_weight' => fake()->randomFloat(2, 0.01, 1000),
            'cost' => fake()->randomFloat(2, 0.01, 1000),
        ];
    }
}
