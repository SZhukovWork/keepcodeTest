<?php

namespace App\Models\Order;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "payment_time",
    ];

    public $timestamps = false;

    protected $casts = [
        "payment_time"=>"datetime"
    ];

    public function products(): HasMany{
        return $this->hasMany(OrderProduct::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
