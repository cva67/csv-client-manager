<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $fillable = ['company_name','email','phone_number','hash',
    'is_duplicate','import_job_id','duplicate_group_id'];
    protected $casts = [
        'is_duplicate' => 'boolean',
    ];

    public function importJob():BelongsTo
    {
        return $this->belongsTo(ImportJob::class);
    }

     public function duplicateGroup():BelongsTo
    {
        return $this->belongsTo(DuplicateGroup::class);
    }
}


