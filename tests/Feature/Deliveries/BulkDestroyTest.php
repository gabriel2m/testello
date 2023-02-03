<?php

namespace Tests\Feature\Customers;

use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulkDestroyTest extends TestCase
{
    use RefreshDatabase;

    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = Customer::factory()->create();
        Delivery::factory(20)->create([
            'customer_id' => $this->customer->id
        ]);
    }

    public function test_customers_can_be_deleted(): void
    {
        $this
            ->actingAs($this->user)
            ->get('customers/1');

        $response = $this
            ->actingAs($this->user)
            ->delete('customers/1/deliveries');

        $response->assertRedirect('customers/1');

        $this->assertDatabaseEmpty(Delivery::class);
    }
}
