<?php

namespace App\Services;

use App\Models\Client;
use App\Models\DuplicateGroup;

class DuplicateDetectionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function check(array $data):array
    {
       $hash = $this->generateHash($data);

       $existingRow = Client::firstWhere('hash', $hash);

    if (!$existingRow) {
            return [
                'hash' => $hash,
                'is_duplicate' => false,
                'group_id' => null,
            ];
        }

        $group = DuplicateGroup::firstOrCreate([
            'duplicate_hash' => $hash
        ]);

        return [
            'hash' => $hash,
            'is_duplicate' => true,
            'group_id' => $group->id,
        ];
    }

    protected function generateHash(array $data): string
{
    
    $email = strtolower(trim($data['email']));

    $phone = preg_replace(
        '/\D/','',$data['phone_number']
    );
   
    $company = strtolower($data['company_name']);
    $company = str_replace(' ', '', $company);
    $company = str_replace('.', '', $company);
    $company = preg_replace('/[^a-z0-9]/', '', $company);

    return md5(
        $company . '|' . $email . '|' . $phone
    );
}
}
