<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
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

    public function test_has_customers_paginated()
    {
        Customer::factory(15)->create();

        $this
            ->actingAs($this->user)
            ->get('customers')
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Customers/Index')
                    ->has(
                        'customers.data',
                        10,
                        fn (Assert $page) => $page
                            ->where('name', Customer::orderBy('name')->first()->name)
                            ->etc()
                    )
            );
    }
}
