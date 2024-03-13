<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "category_id";
    protected $keyType = "string";

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "category_id");
    }
}
