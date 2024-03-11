<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "treatment_id";
    protected $keyType = "string";


    protected $casts = [
        'price' => MoneyCast::class,
    ];
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, "patient_id");
    }
}
