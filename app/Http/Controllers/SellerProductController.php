<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductBrand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 


class SellerProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $data = $request->validate([
            'product_name'        => 'required|string',
            'product_description' => 'nullable|string',
            'brands'              => 'required|array|min:1',
            'brands.*.brand_name'   => 'required|string|max:255',
            'brands.*.brand_detail' => 'nullable|string',
            'brands.*.brand_price'  => 'required|numeric|min:0',
            'brands.*.brand_image'  => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $product = product::create([
                'seller_id' => $request->user()->id,
                'product_name' => $data['product_name'],
                'product_description' => $data['product_description'] ?? null,
            ]);

            foreach ($data['brands'] as $brand) {
                $path = null;
                if (isset($brand['brand_image'])) {
                    $path = $brand['brand_image']->store('brand_images','public');
                }

                ProductBrand::create([
                    'product_id'   => $product->id,
                    'brand_name'   => $brand['brand_name'],
                    'brand_detail' => $brand['brand_detail'] ?? null,
                    'brand_image'  => $path,
                    'brand_price'  => $brand['brand_price'],
                ]);
            }

            DB::commit();
            return response()->json($product->load('brands'),201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=>'Could not add product'],500);
        }
    }

    public function listProducts(Request $request)
    {
        $products = Product::with('brands')
            ->where('seller_id',$request->user()->id)
            ->paginate(10);

        return response()->json($products);
    }

    public function deleteProduct($id, Request $request)
    {
        $product = Product::where('id',$id)
            ->where('seller_id',$request->user()->id)
            ->first();

        if (!$product) {
            return response()->json(['message'=>'Product not found'],404);
        }

        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return response()->json(['message'=>'Product deleted']);
        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);

            DB::rollBack();
            return response()->json(['message'=>'Could not delete product'],500);
        }
    }
}
