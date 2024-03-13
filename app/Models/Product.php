<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "product_id";
    protected $keyType = "string";

    public function flows(): HasMany
    {
        return $this->hasMany(ProductFlow::class, "product_id");
    }
}
