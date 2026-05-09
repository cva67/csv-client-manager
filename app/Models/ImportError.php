<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportError extends Model
{
    protected $fillable = ['row_number','raw_data','error_messages','import_job_id'];

    protected $casts = [
    'error_messages' => 'array',
    'raw_data'=> 'array',
    ];

     public function importJob():BelongsTo
    {
        return $this->belongsTo(ImportJob::class);
    }
}
