<?php

use App\Models\ImportJob;
use Maatwebsite\Excel\Facades\Excel; 
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
   
    $this->importJob = ImportJob::create([
        'file_name'  => 'test.csv',
        'status'     => 'completed',
        'total_rows' => 5,
    ]);
});

it('can export only duplicates', function () {
    Excel::fake();

   
    $response = $this->getJson("/api/client/{$this->importJob->id}/export/?filter=duplicates");

    $response->assertOk();

   
    Excel::assertDownloaded("{$this->importJob->file_name}-duplicates.csv"); 
});