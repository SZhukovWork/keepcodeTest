<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Order\Order;
use App\Models\Order\OrderProduct;
use App\Models\Product;
use App\Models\PurchaseType\ProductPurchase;
use App\Models\PurchaseType\PurchaseType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrdersController extends Controller
{
    public function allPage(): Response
    {
        return Inertia::render('Orders', [
            "orders"=>Order::with(["products","products.purchaseType","products.product","user"])->where(["user_id"=>Auth::id()])->get()
        ]);
    }
    public function allApi(): JsonResponse
    {
        return response()->json([
            "orders"=>Order::with(["products","products.purchaseType","products.product","user"])->where(["user_id"=>Auth::id()])->get()
        ]);
    }

    public function create(OrderCreateRequest $request)
    {
        $product = Product::find($request->product_id);
        if(empty($product)){
            throw new ModelNotFoundException();
        }
        $order = new Order([
            "user_id"=>Auth::id(),
            "payment_time"=>time(),
        ]);
        $order->save();
        $orderProduct = new OrderProduct([
            "product_id"=>$product->id,
            "price"=>$product->price,
            "order_id"=>$order->id,
            "purchase_type_id"=>null,
        ]);
        if($request->purchase_type){
            $purchaseType = PurchaseType::find($request->purchase_type);
            if(empty($purchaseType)){
                throw new ModelNotFoundException();
            }
            /** @var ProductPurchase $productPurchase */
            $productPurchase = ProductPurchase::where(["product_id"=>$product->id,"purchase_type_id"=>$request->purchase_type])->first();

            $orderProduct->purchaseType()->associate($productPurchase->type);
            $orderProduct->price = $productPurchase->price;
        }
        $orderProduct->order()->associate($order);
        $orderProduct->push();
        if($request->hasHeader("X-Inertia")){
            return Redirect::route('orders.page');
        }
        return response()->json($order);
    }

    public function productStatus($orderId, $productId):JsonResponse
    {
        $order = Order::find($orderId);
        /** @var Carbon $paymentTime */
        $paymentTime = $order->payment_time;
        if(empty($order)){
            throw new ModelNotFoundException();
        }
        $product = OrderProduct::where(["order_id"=>$orderId,"product_id"=>$productId])->first();
        if(empty($product)){
            throw new ModelNotFoundException();
        }
        if($product->purchase_type_id){
            /** @var PurchaseType $type */
            $type = $product->purchaseType;
            return response()->json([
                "expiresIn"=>$paymentTime->addSeconds($type->validity_period),
                "currentTime"=>new Carbon(),
            ]);
        }
        return response()->json([
            "expiresIn"=>false,
        ]);
    }

}
