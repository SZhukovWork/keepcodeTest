<?php

namespace App\Models;

use App\Models\PurchaseType\ProductPurchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "title",
        "price",
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }
}
