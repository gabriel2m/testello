<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_page_is_displayed(): void
    {
        Customer::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->get('customers/1');

        $response->assertOk();
    }

    public function test_can_view_customer()
    {
        $customer = Customer::factory()->create();

        $this
            ->actingAs($this->user)
            ->get('customers/1')
            ->assertInertia(
                fn (Assert $assert) => $assert
                    ->component('Customers/Show')
                    ->has('customer', fn (Assert $assert) => $assert
                        ->where('id', $customer->id)
                        ->where('name', $customer->name)
                        ->etc())
            );
    }
}
