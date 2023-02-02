<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('customers');

        $response->assertOk();
    }

    public function test_can_view_customers()
    {
        $customers = Customer::factory(15)->create();

        $first = $customers->sortBy('name')->first();

        $this
            ->actingAs($this->user)
            ->get('customers')
            ->assertInertia(
                fn (Assert $assert) => $assert
                    ->component('Customers/Index')
                    ->has('customers.data', 10)
                    ->has(
                        'customers.data.0',
                        fn (Assert $assert) => $assert
                            ->where('id', $first->id)
                            ->where('name', $first->name)
                            ->etc()
                    )
            );
    }
}
