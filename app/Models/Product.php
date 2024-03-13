<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "product_id";
    protected $keyType = "string";

    protected $casts = [
        "price" => MoneyCast::class,
    ];

    public function flows(): HasMany
    {
        return $this->hasMany(ProductFlow::class, "product_id");
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, "category_id");
    }
}
