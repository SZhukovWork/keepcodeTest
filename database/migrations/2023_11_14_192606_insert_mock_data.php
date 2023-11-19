<?php

use App\Models\Product;
use App\Models\PurchaseType\ProductPurchase;
use App\Models\PurchaseType\PurchaseType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::insert([
            [
                "name"=>"admin",
                "email"=>"admin@admin.admin",
                "email_verified_at"=>null,
                "password"=>Hash::make("12341234"),
            ]
        ]);
        PurchaseType::insert([
            [
                "title"=>"4 часа",
                "validity_period"=>4*60*60
            ],
            [
                "title"=>"8 часов",
                "validity_period"=>8*60*60
            ],
            [
                "title"=>"12 часов",
                "validity_period"=>12*60*60
            ],
            [
                "title"=>"24 часа",
                "validity_period"=>24*60*60
            ]
        ]);
        Product::insert([
            [
                "title"=>"CS 2 Prime status",
                "price"=> 250,
            ],
            [
                "title"=>"DOKA 2 пул привязочников",
                "price"=> 1000,
            ],
        ]);
        ProductPurchase::insert([
            [
                "product_id"=>1,
                "purchase_type_id"=>1,
                "price"=> 25,
            ],
            [
                "product_id"=>1,
                "purchase_type_id"=>2,
                "price"=> 50,
            ],
            [
                "product_id"=>1,
                "purchase_type_id"=>3,
                "price"=> 80,
            ],
            [
                "product_id"=>1,
                "purchase_type_id"=>4,
                "price"=> 100,
            ],
            [
                "product_id"=>2,
                "purchase_type_id"=>1,
                "price"=> 25,
            ],
            [
                "product_id"=>2,
                "purchase_type_id"=>2,
                "price"=> 50,
            ],
            [
                "product_id"=>2,
                "purchase_type_id"=>3,
                "price"=> 80,
            ],
            [
                "product_id"=>2,
                "purchase_type_id"=>4,
                "price"=> 100,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
