<?php
use App\Imports\ClientsImport;

use App\Models\ImportJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

uses(Tests\TestCase::class, RefreshDatabase::class);


beforeEach(function () {
    $this->importJob = ImportJob::create([
        'file_name'  => 'test.csv',
        'status'     => 'pending',
        'total_rows' => 0,
    ]);

    $this->import = new ClientsImport($this->importJob);
});

it('stores error when exception occurs', function () {
    $rows = Collection::make([
        collect([
            'company_name' => 'Acme Corp',
            'email'        => null,
            'phone_number' => '1234567890',
        ])
    ]);

    $this->import->collection($rows);

    $this->assertDatabaseHas('import_errors', [
        'import_job_id' => $this->importJob->id,
    ]);
});
