<?php

namespace App\Models\Order;

use App\Models\Product;
use App\Models\PurchaseType\PurchaseType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "product_id",
        "purchase_type_id",
        "price",
    ];

    public $timestamps = false;

    public function order():BelongsTo{
        return $this->belongsTo(Order::class);
    }
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function purchaseType():BelongsTo{
        return $this->belongsTo(PurchaseType::class,"purchase_type_id","id");
    }
}
