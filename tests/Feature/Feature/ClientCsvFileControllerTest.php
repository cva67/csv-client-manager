<?php

use App\Models\Client;
use App\Models\ImportJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

it('can upload a csv file and creates a pending job', function () {
        $file = UploadedFile::fake()->createWithContent(
            'clients.csv',
            "company_name,email,phone_number\nAcme Corp,test@acme.com,1234567890"
        );

        $response = $this->postJson('/api/imports', [
            'file_name' => $file,
        ]);

        $response->assertOk()
            ->assertJsonStructure(['message', 'import_job_id']);

        $this->assertDatabaseHas('import_jobs', [
            'file_name' => 'clients.csv',
            'status'    => 'pending',
        ]);
    });

   