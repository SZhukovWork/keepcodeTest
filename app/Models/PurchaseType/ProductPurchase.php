<?php

namespace App\Models\PurchaseType;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPurchase extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "product_id",
        "purchase_type_id",
        "price",
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PurchaseType::class,"purchase_type_id","id");
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
