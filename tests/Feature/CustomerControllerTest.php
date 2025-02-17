<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test customer perPage, data and current page
    public function it_can_get_customers_with_perPage()
    {
        Customer::factory()->count(15)->create();

        $response = $this->get(route('customers.index', [
            'perPage' => 5,
        ]));

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonFragment([
            'per_page' => 5,
        ]);

        $response->assertJsonFragment([
            'total' => 15,
            'current_page' => 1,
        ]);
    }

    // Test searching customers by keyword
    public function test_search_with_keyword()
    {
        Customer::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'gender' => 'Male',
            'ip_address' => '192.168.1.1',
            'company' => 'Company X',
            'city' => 'City Y',
            'title' => 'Manager',
            'website' => 'https://john-doe.com',
        ]);

        Customer::factory()->count(14)->create();

        $response = $this->get(route('customers.index', [
            'keyword' => 'John',
            'perPage' => 5,
        ]));

        $response->assertStatus(200);
        $this->assertGreaterThan(1, $response['total']);
    }

    // Test sorting customers by a specific field and order
    public function test_search_with_sortBy_and_sortOrder()
    {
        $customers = [
            ['first_name' => 'Alisha', 'last_name' => 'Benton', 'email' => 'alisha@example.com', 'gender' => 'Female', 'ip_address' => '192.168.1.2', 'company' => 'Company A', 'city' => 'City A', 'title' => 'Engineer', 'website' => 'https://alisha.com'],
            ['first_name' => 'Bonnie', 'last_name' => 'Jones', 'email' => 'bonnie@example.com', 'gender' => 'Female', 'ip_address' => '192.168.1.3', 'company' => 'Company B', 'city' => 'City B', 'title' => 'Developer', 'website' => 'https://bonnie.com'],
            ['first_name' => 'Dulce', 'last_name' => 'Parker', 'email' => 'dulce@example.com', 'gender' => 'Female', 'ip_address' => '192.168.1.4', 'company' => 'Company C', 'city' => 'City C', 'title' => 'Designer', 'website' => 'https://dulce.com'],
            ['first_name' => 'Eve', 'last_name' => 'Smith', 'email' => 'eve@example.com', 'gender' => 'Female', 'ip_address' => '192.168.1.5', 'company' => 'Company D', 'city' => 'City D', 'title' => 'Manager', 'website' => 'https://eve.com'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        $response = $this->get(route('customers.index', [
            'sortBy' => 'first_name',
            'sortOrder' => 'asc',
            'perPage' => 5,
        ]));

        $response->assertStatus(200);

        $data = $response->json('data');
        $firstNames = array_column($data, 'first_name');

        sort($firstNames);
        $this->assertSame($firstNames, array_column($data, 'first_name'));

        $responseDesc = $this->get(route('customers.index', [
            'sortBy' => 'first_name',
            'sortOrder' => 'desc',
            'perPage' => 5,
        ]));

        $responseDesc->assertStatus(200);

        $dataDesc = $responseDesc->json('data');
        $firstNamesDesc = array_column($dataDesc, 'first_name');

        rsort($firstNamesDesc);
        $this->assertSame($firstNamesDesc, $firstNamesDesc);
    }



    public function it_can_show_customer_details()
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.show', $customer));

        $response->assertStatus(200);
        $response->assertJsonFragment(['first_name' => $customer->first_name]);
    }

    
}