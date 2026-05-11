<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportJob extends Model
{
    
    protected $fillable = ['file_name','total_rows','success_rows',
    'failed_rows','duplicate_rows','status'];

    public function clients():HasMany
    {
        return $this->hasMany(Client::class)->chaperone();
    }

     public function importErrors():HasMany
    {
        return $this->hasMany(ImportError::class)->chaperone();
    }

}
