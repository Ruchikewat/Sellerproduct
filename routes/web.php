<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminWebController;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/admin/login', [AdminWebController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminWebController::class, 'login'])->name('admin.login');

Route::middleware('web')->group(function () {
    Route::get('/admin/dashboard', [AdminWebController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/seller/create', [AdminWebController::class, 'showCreateSellerForm'])->name('admin.seller.create.form');
    Route::post('/admin/seller/create', [AdminWebController::class, 'createSellerFromForm'])->name('admin.seller.create');
    Route::get('/admin/sellers', [AdminWebController::class, 'listSellers'])->name('admin.sellers');
    Route::get('/seller/login', [AdminWebController::class, 'showSellerLogin'])->name('seller.login');
    Route::post('/seller/login', [AdminWebController::class, 'sellerLogin']);
    Route::get('/seller/dashboard', [AdminWebController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::get('/seller/add-product', [AdminWebController::class, 'showAddProduct'])->name('seller.add-product');
    Route::post('/seller/add-product', [AdminWebController::class, 'addProduct']);
    Route::get('/seller/products/{id}/edit', [AdminWebController::class, 'editProduct'])->name('seller.product.edit');
    Route::put('/seller/products/{id}', [AdminWebController::class, 'updateProduct'])->name('seller.product.update');
    Route::delete('/seller/products/{id}', [AdminWebController::class, 'deleteProduct'])->name('seller.product.delete');
    Route::get('/seller/products', [AdminWebController::class, 'sellerProducts'])->name('seller.products');
    Route::post('/seller/logout', function (Request $request) {
        $request->session()->forget('seller_token');
        return redirect()->route('seller.login');
    })->name('seller.logout');
    
    Route::post('/admin/logout', function (Request $request) {
        $request->session()->forget('admin_token');
        return redirect()->route('admin.login.form');
    })->name('admin.logout');
});
