<?php

namespace Tests\Feature\Customers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = Customer::factory()->create();
    }

    public function test_customers_can_be_deleted(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete('customers/1');

        $response->assertRedirect('customers');

        $this->assertDatabaseEmpty(Customer::class);
    }
}
