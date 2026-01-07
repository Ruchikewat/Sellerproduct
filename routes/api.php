<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\ProductPdfController;

Route::post('/admin/login',[AuthController::class,'adminLogin']);
Route::post('/seller/login',[AuthController::class,'sellerLogin']);

Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    Route::post('/admin/seller/create',[AdminController::class,'createSeller']);
    Route::get('/admin/seller/list',[AdminController::class,'listSellers']);
});

Route::middleware(['auth:sanctum','role:seller'])->group(function () {
    Route::post('/seller/product/add',[SellerProductController::class,'addProduct']);
    Route::get('/seller/product/list',[SellerProductController::class,'listProducts']);
    Route::delete('/seller/product/{id}',[SellerProductController::class,'deleteProduct']);
});

Route::middleware(['auth:sanctum','role:seller'])->get(
    '/seller/product/{id}/pdf',
    [ProductPdfController::class,'viewProduct']
);

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
