<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'ip_address' => $this->faker->ipv4,
            'company' => $this->faker->company,
            'city' => $this->faker->city,
            'title' => $this->faker->jobTitle,
            'website' => $this->faker->url,
        ];
    }
}
