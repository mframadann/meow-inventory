<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "patient_id";
    protected $keyType = "string";

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, "owner_id");
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class, "patient_id");
    }
}
