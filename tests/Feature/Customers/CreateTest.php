<?php

namespace Tests\Feature\Customers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('customers/create');

        $response->assertOk();
    }

    public function test_customers_can_be_created(): void
    {
        $data = [
            'name' => 'Test Customer',
        ];

        $response = $this
            ->actingAs($this->user)
            ->post('customers', $data);

        $response->assertRedirect('customers/1');

        $data['id'] = 1;

        $this->assertDatabaseHas(Customer::class, $data);
    }
}
