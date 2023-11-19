<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductCreateRequest;
use App\Models\Product;
use App\Models\PurchaseType\ProductPurchase;
use App\Models\PurchaseType\PurchaseType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{

    public function allPage(): Response
    {
        return Inertia::render('Products', [
            "products"=>Product::with(["purchases","purchases.type"])->get()
        ]);
    }
    public function allApi(): JsonResponse
    {
        return response()->json([
            "products"=>Product::with(["purchases","purchases.type"])->get()
        ]);
    }

    public function createPage(): Response
    {
        return Inertia::render('CreateProduct', [
            "purchaseTypes"=>PurchaseType::get()
        ]);
    }
    public function create(ProductCreateRequest $request)
    {
        $product = Product::create([
            "title"=>$request->title,
            "price"=>$request->price,
        ]);
        $product->save();
        if($request->purchaseTypes){
            foreach ($request->purchaseTypes as $purchaseTypeId => $price){
                $productPurchase = new ProductPurchase([
                    "purchase_type_id"=>$purchaseTypeId,
                    "product_id"=>$product->id,
                    "price"=>$price,
                ]);
                $productPurchase->product()->associate($product)->push();
            }
        }
        if($request->hasHeader("X-Inertia")){
            return Redirect::route('products.page');
        }
        return response()->json([
            "product"=>$product,
        ]);
    }

}
