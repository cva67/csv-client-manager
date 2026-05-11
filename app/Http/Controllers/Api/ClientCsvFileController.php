<?php

namespace App\Http\Controllers\Api;

use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImportJobRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\DuplicateGroup;
use App\Models\ImportJob;
use App\Services\ImportJobService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientCsvFileController extends Controller
{
   
    public function store(StoreImportJobRequest $request, ImportJobService $importJobService)
    {
       
        $importJob = $importJobService->import($request->file('file_name'));

         return response()->json([
            'message' => 'Import started',
            'import_job_id' => $importJob->id,
        ]);
    }
    public function duplicatesInGroup(ImportJob $importJob)
    {
        $duplicates = DuplicateGroup::with('clients')
        ->whereHas('clients', function ($query) use ($importJob) {

            $query->where(
                'import_job_id',
                $importJob->id
            );

        })
        ->get();

    return response()->json($duplicates);

    }
    public function duplicates()
    {
        $duplicateClients = Client::where('is_duplicate', true)->get();

        return response()->json($duplicateClients);
    }

    public function update(UpdateClientRequest $request, int $id)
{
    $client = Client::find($id);

    if (!$client) {
        return response()->json([
            'success' => false,
            'message' => 'Client not found'
        ], 404);
    }

    $client->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Client updated successfully',
        'data' => $client
    ]);
}
public function export(Request $request,ImportJob $importJob) {
    
    $filter = $request->query('filter')?? 'all';

    if (!in_array($filter, [
        'all',
        'duplicates',
        'unique'
    ])) {

        return response()->json([
            'message' => 'Invalid filter'
        ], 422);
    }

    return Excel::download(
        new ClientsExport(
            $importJob->id,
            $filter
        ),
        "{$importJob->file_name}-{$filter}.csv"
    );
}
}
