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
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('customers');

        $response->assertOk();
    }

    public function test_has_customers_paginated()
    {
        $user = User::factory()->create();

        Customer::factory(15)->create();

        $this
            ->actingAs($user)
            ->get('customers')
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Customers/Index')
                    ->has(
                        'customers.data',
                        10,
                        fn (Assert $page) => $page
                            ->where('id', 1)
                            ->where('name', Customer::first()->name)
                            ->etc()
                    )
            );
    }
}
