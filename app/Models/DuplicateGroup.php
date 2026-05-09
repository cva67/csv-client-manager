<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DuplicateGroup extends Model
{
    protected $fillable = ['duplicate_hash']; 

    public function clients():HasMany
    {
        return $this->hasMany(Client::class)->chaperone();
    }
}
