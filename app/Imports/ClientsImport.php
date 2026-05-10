<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\ImportError;
use App\Models\ImportJob;
use App\Services\DuplicateDetectionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ClientsImport implements ToCollection,WithHeadingRow,WithChunkReading,ShouldQueue,WithValidation, SkipsOnFailure
{
    use Importable;
    public function __construct(protected ImportJob $importJob)
    {
        $this->importJob = $importJob;
        
    }
    public function collection(Collection $rows)
    {
        foreach( $rows as $rowNumber => $row ){
            try{
                $data = $row->toArray();

                $duplicateData = app(DuplicateDetectionService::class)->check($data);

                 if ($duplicateData['is_duplicate']) {
                    $this->importJob->increment('duplicate_rows',1);
                  }

                Client::create([
                    'company_name' => $data['company_name'],
                    'email' => $data['email'],
                    'phone_number' => $data['phone_number'],
                    'hash' => $duplicateData['hash'],
                    'is_duplicate' => $duplicateData['is_duplicate'],
                    'duplicate_group_id' => $duplicateData['group_id'],
                    'import_job_id' => $this->importJob->id,
                ]);
                $this->importJob->increment('success_rows', 1);

            }catch (Throwable $e) {
                    $this->storeError(
                    $rowNumber,
                    [$e->getMessage()],
                    $row
                );
                $this->importJob->increment('failed_rows', 1);
        }
    }
    }
     public function chunkSize(): int
    {
        return 1000;
    }
     public function rules(): array
    {
        return [
        '*.company_name' => 'required|string|max:255',
        '*.email' => 'required|email',
        '*.phone_number' => 'required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {

            $this->storeError(
                $failure->row(),
                $failure->errors(),
                $failure->values()
            );

            $this->importJob->increment('failed_rows', 1);
        }
    }
     protected function storeError(
        int $rowNumber,
        array $errors,
        mixed $row
    ) {

        ImportError::create([
            'import_job_id' => $this->importJob->id,
            'row_number' => $rowNumber,
            'error_messages' => $errors,
            'raw_data' => $row,
        ]);
    }
}
