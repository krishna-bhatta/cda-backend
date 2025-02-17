<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read CSV file
        $csvFile = storage_path('app/private/customers.csv');
        $file = fopen($csvFile, 'r');

        // Skip the header row
        fgetcsv($file);

        // Iterate through each row and insert data into the customers table
        while (($row = fgetcsv($file)) !== false) {
            Customer::create([
                'first_name' => $row[1],
                'last_name' => $row[2],
                'email' => $row[3],
                'gender' => $row[4],
                'ip_address' => $row[5],
                'company' => $row[6],
                'city' => $row[7],
                'title' => $row[8],
                'website' => Str::before($row[9], '?'),
            ]);
        }

        fclose($file);
    }
}
