<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'company_name' => 'Acme Corp',
                'email' => 'acme@example.com',
                'phone_number' => '9800000001',
            ],
            [
                'company_name' => 'Beta Ltd',
                'email' => 'beta@example.com',
                'phone_number' => '9800000002',
            ],
            [
                'company_name' => 'Gamma Inc',
                'email' => 'gamma@example.com',
                'phone_number' => '9800000003',
            ],

            // duplicate example 
            [
                'company_name' => 'Acme Duplicate',
                'email' => 'acme@example.com',
                'phone_number' => '9800000009',
            ],
        ];

        foreach ($clients as $client) {

            $hash = md5(
                strtolower($client['company_name']) . '|' .
                $client['email'] . '|' .
                $client['phone_number']
            );

            Client::create([
                ...$client,
                'hash' => $hash,
                'is_duplicate' => false,
                'import_job_id' => null,
                'duplicate_group_id' => null,
            ]);
        }
    
    }
}
