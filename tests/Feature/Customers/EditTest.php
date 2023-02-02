<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer = Customer::factory()->create();
    }

    public function test_edit_page_is_displayed(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('customers/1/edit');

        $response->assertOk();
    }

    public function test_customers_can_be_edited(): void
    {
        $data = [
            'name' => 'Test Customer',
        ];

        $response = $this
            ->actingAs($this->user)
            ->put('customers/1', $data);

        $response->assertRedirect('customers/1');

        $data['id'] = 1;

        Customer::where($data)->exists();
    }
}
