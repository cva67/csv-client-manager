<?php

namespace App\Services;

use App\Models\ImportJob;

class ImportJobService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(string $filename, string $origialpath) : ImportJob
    {
        $importJob = ImportJob::create([
            'filename'=>$filename,
            'status' => 'pending'
        ]);

        //job queues process

        return $importJob;

    }
}
