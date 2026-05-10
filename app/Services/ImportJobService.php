<?php

namespace App\Services;

use App\Imports\ClientsImport;
use App\Models\ImportJob;
use Maatwebsite\Excel\Excel;

class ImportJobService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function import($file) : ImportJob
    {
        $totalRows = count(file($file->getRealPath())) - 1;

        $importJob = ImportJob::create([
            'filename'=>$file->getClientOriginalName(),
            'status' => 'pending',
            'total_rows' => $totalRows
        ]);
       
        Excel::queueImport(
            new ClientsImport($importJob),
            $file
        );

        return $importJob;

    }
}
