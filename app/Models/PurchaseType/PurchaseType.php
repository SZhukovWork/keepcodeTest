<?php

namespace App\Models\PurchaseType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseType extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "title",
        "validity_period",
    ];
}
