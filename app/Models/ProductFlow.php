<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFlow extends Model
{
    use HasFactory;
    use HasUuids;
    public $timestamps = false;
    protected $primaryKey = "pf_id";
    protected $keyType = "string";



    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id");
    }
}
