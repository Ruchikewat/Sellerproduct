<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductPdfController extends Controller
{
    public function viewProduct($id, Request $request)
    {
        $product = Product::with('brands')
            ->where('id',$id)
            ->where('seller_id',$request->user()->id)
            ->firstOrFail();

        $totalPrice = $product->brands->sum('brand_price');

        return response()->json([
            'product_name' => $product->product_name,
            'product_description' => $product->product_description,
            'brands' => $product->brands,
            'total_price' => $totalPrice,
        ]);
    }
}
