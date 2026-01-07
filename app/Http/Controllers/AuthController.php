<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email',$data['email'])->where('role','admin')->first();

            if (!$user || !Hash::check($data['password'],$user->password)) {
                return response()->json(['message'=>'Invalid credentials'],401);
            }

            $token = $user->createToken('admin-token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'role' => $user->role,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Something went wrong'],500);
        }
    }

    public function sellerLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email',$data['email'])->where('role','seller')->first();

            if (!$user || !Hash::check($data['password'],$user->password)) {
                return response()->json(['message'=>'Invalid credentials'],401);
            }

            $token = $user->createToken('seller-token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'role' => $user->role,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Something went wrong'],500);
        }
    }
}
