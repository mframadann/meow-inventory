<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "owner_id";
    protected $keyType = "string";

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}
