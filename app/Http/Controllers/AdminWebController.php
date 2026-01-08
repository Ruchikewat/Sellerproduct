<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminWebController extends Controller
{
    private string $apiBase = 'http://127.0.0.1:8000/api';

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // API call to admin login
        $response = Http::post($this->apiBase . '/admin/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if (!$response->successful()) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        $data = $response->json();

        // token session me save karo
        $request->session()->put('admin_token', $data['access_token'] ?? null);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard(Request $request)
    {
        if (!$request->session()->has('admin_token')) {
            return redirect()->route('admin.login.form');
        }

        return view('admin.dashboard');
    }

    public function showCreateSellerForm(Request $request)
    {
        if (!$request->session()->has('admin_token')) {
            return redirect()->route('admin.login.form');
        }

        return view('admin.create-seller');
    }

    public function createSellerFromForm(Request $request)
    {
        if (!$request->session()->has('admin_token')) {
            return redirect()->route('admin.login.form');
        }

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'mobile'   => 'required',
            'country'  => 'required',
            'state'    => 'required',
            'skills'   => 'required',
            'password' => 'required|min:6',
        ]);

        $token = $request->session()->get('admin_token');

        // skills ko array bana ke API ko bhejenge
        $skillsArray = array_map('trim', explode(',', $request->skills));

        $response = Http::withToken($token)->post($this->apiBase . '/admin/seller/create', [
            'name'     => $request->name,
            'email'    => $request->email,
            'mobile'   => $request->mobile,
            'country'  => $request->country,
            'state'    => $request->state,
            'skills'   => $skillsArray,
            'password' => $request->password,
        ]);

        // Log response for debugging
        Log::info('Seller API Response', [
            'status' => $response->status(),
            'body' => $response->body(),
            'headers' => $response->headers()
        ]);

        if (!$response->successful()) {
            $errorData = $response->json('message', 'API error: seller create failed');
            return back()->withErrors(['form' => $errorData])->withInput();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Seller created successfully');
    }

    public function listSellers(Request $request)
{
    if (!$request->session()->has('admin_token')) {
        return redirect()->route('admin.login.form');
    }

    $token = $request->session()->get('admin_token');
    $response = Http::withToken($token)->get($this->apiBase . '/admin/sellers', [
        'page' => $request->get('page', 1),
        'per_page' => 10
    ]);

    if (!$response->successful()) {
        return back()->withErrors(['form' => 'Failed to load sellers']);
    }

    $sellers = $response->json('data', []);
    return view('admin.sellers', compact('sellers'));
}

// In AdminWebController or new SellerWebController
public function showSellerLogin() { return view('seller.login'); }

public function sellerLogin(Request $request)
{
    $request->validate(['email' => 'required|email', 'password' => 'required']);
    
    $response = Http::post($this->apiBase . '/seller/login', $request->only('email', 'password'));
    
    if (!$response->successful()) {
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    
    $request->session()->put('seller_token', $response->json('access_token'));
    return redirect()->route('seller.dashboard');
}

public function sellerDashboard(Request $request)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    return view('seller.dashboard');
}

public function showAddProduct(Request $request)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    return view('seller.add-product');
}

public function addProduct(Request $request)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'brands' => 'required|array|min:1',
        'brands.*.name' => 'required',
        'brands.*.detail' => 'required',
        'brands.*.image' => 'required|image',
        'brands.*.price' => 'required|numeric|min:0'
    ]);
    
    $token = $request->session()->get('seller_token');
    $brandsData = [];
    foreach ($request->brands as $brand) {
        $brandsData[] = [
            'name' => $brand['name'],
            'detail' => $brand['detail'],
            'image' => $brand['image']->store('public/brands'),
            'price' => $brand['price']
        ];
    }
    
    $response = Http::withToken($token)->post($this->apiBase . '/seller/product/add', [
        'name' => $request->name,
        'description' => $request->description,
        'brands' => $brandsData
    ]);
    
    if (!$response->successful()) {
        return back()->withErrors(['form' => 'Product add failed']);
    }
    
    return redirect()->route('seller.products')->with('success', 'Product added');
}

public function editProduct(Request $request, $id)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    $token = $request->session()->get('seller_token');
    $response = Http::withToken($token)->get($this->apiBase . '/seller/product/' . $id);
    if (!$response->successful()) {
        return back()->with('error', 'Product not found');
    }
    $product = $response->json();
    return view('seller.edit-product', compact('product'));
}

public function updateProduct(Request $request, $id)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    $token = $request->session()->get('seller_token');
    $response = Http::withToken($token)->put($this->apiBase . '/seller/product/' . $id, $request->all());
    if ($response->successful()) {
        return redirect()->route('seller.products')->with('success', 'Product updated');
    }
    return back()->with('error', 'Update failed');
}

public function deleteProduct(Request $request, $id)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    $token = $request->session()->get('seller_token');
    $response = Http::withToken($token)->delete($this->apiBase . '/seller/product/' . $id);
    if ($response->successful()) {
        return redirect()->route('seller.products')->with('success', 'Product deleted');
    }
    return back()->with('error', 'Delete failed');
}


public function sellerProducts(Request $request)
{
    if (!$request->session()->has('seller_token')) {
        return redirect()->route('seller.login');
    }
    
    $token = $request->session()->get('seller_token');
    $response = Http::withToken($token)->get($this->apiBase . '/seller/products?page=' . ($request->get('page', 1)));
    
    $products = $response->json('data', []);
    return view('seller.products', compact('products'));
}


}
