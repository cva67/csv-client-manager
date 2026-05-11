<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExport implements FromQuery,WithHeadings,WithMapping
{
    public function __construct(
        protected int $importJobId,
        protected string $filter='all',
    ) {}
    public function query()
    {
         $query = Client::query()->where(
                'import_job_id',
                $this->importJobId
            );
        if ($this->filter === 'duplicates') {

            $query->where(
                'is_duplicate',
                true
            );
        }
        if ($this->filter === 'unique') {

            $query->where(
                'is_duplicate',
                false
            );
        }
        
        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Company Name',
            'Email',
            'Phone Number',
            'Is Duplicate',
            
        ];
    }

    public function map($client): array
    {
        return [
            $client->id,
            $client->company_name,
            $client->email,
            $client->phone_number,
            $client->is_duplicate,
        ];
    }
}
