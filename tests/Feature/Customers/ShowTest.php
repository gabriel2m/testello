<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ShowTest extends TestCase
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

    public function test_show_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('customers/1');

        $response->assertOk();
    }

    public function test_can_view_customer()
    {
        $this
            ->actingAs($this->user)
            ->get('customers/1')
            ->assertInertia(
                fn (Assert $assert) => $assert
                    ->component('Customers/Show')
                    ->has('customer', fn (Assert $assert) => $assert
                        ->where('id', $this->customer->id)
                        ->where('name', $this->customer->name)
                        ->etc())
            );
    }

    public function test_can_view_deliveries()
    {
        $first = $this->customer->deliveries->first();
        $this
            ->actingAs($this->user)
            ->get('customers/1')
            ->assertInertia(
                fn (Assert $assert) => $assert
                    ->component('Customers/Show')
                    ->has('deliveries.data', 10)
                    ->has(
                        'deliveries.data.0',
                        fn (Assert $assert) => $assert
                            ->where('id', $first->id)
                            ->where('customer_id', $first->customer_id)
                            ->where('from_postcode', $first->from_postcode)
                            ->where('to_postcode', $first->to_postcode)
                            ->where('from_weight', $first->from_weight)
                            ->where('to_weight', $first->to_weight)
                            ->where('cost', $first->cost)
                            ->etc()
                    )
            );
    }
}
