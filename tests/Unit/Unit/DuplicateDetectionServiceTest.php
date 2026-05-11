<?php

use App\Models\Client;
use App\Models\ImportJob;
use App\Services\DuplicateDetectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->service = new DuplicateDetectionService();
});

it('returns true when duplicate exists', function () {
    $importJob = ImportJob::create([
        'file_name'  => 'test.csv',
        'status'     => 'pending',
        'total_rows' => 1,
    ]);

    $data = [
        'company_name' => 'Acme Corp',
        'email'        => 'test@acme.com',
        'phone_number' => '1234567890',
    ];

    Client::create([
        ...$data,
        'hash'               => md5('acmecorp|test@acme.com|1234567890'),
        'is_duplicate'       => false,
        'import_job_id'      => $importJob->id,
        'duplicate_group_id' => null,
    ]);

    $result = $this->service->check($data);

    expect($result['is_duplicate'])->toBeTrue();
    expect($result['group_id'])->not->toBeNull();
});

it('creates duplicate group when duplicate found', function () {
    $importJob = ImportJob::create([
        'file_name'  => 'test.csv',
        'status'     => 'pending',
        'total_rows' => 1,
    ]);

    $data = [
        'company_name' => 'Acme Corp',
        'email'        => 'test@acme.com',
        'phone_number' => '1234567890',
    ];

    // Create the initial record
    Client::create([
        ...$data,
        'hash'               => md5('acmecorp|test@acme.com|1234567890'),
        'is_duplicate'       => false,
        'import_job_id'      => $importJob->id,
        'duplicate_group_id' => null,
    ]);

    $result = $this->service->check($data);

    
    $this->assertDatabaseHas('duplicate_groups', [
        'duplicate_hash' => $result['hash']
    ]);
});