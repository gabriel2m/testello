<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('customers/create');

        $response->assertOk();
    }

    public function test_customers_can_be_created(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test Customer',
        ];

        $response = $this
            ->actingAs($user)
            ->post('customers', $data);

        $response->assertRedirect('customers');

        $this->assertDatabaseHas(Customer::class, $data);
    }
}
