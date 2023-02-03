<?php

namespace Tests\Feature\Deliveries;

use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulkCreateTest extends TestCase
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

    public function test_bulk_create_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('customers/1/deliveries/create');

        $response->assertOk();
    }
}
