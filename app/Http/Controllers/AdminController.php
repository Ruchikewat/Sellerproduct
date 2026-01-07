<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 

class AdminController extends Controller
{
    public function createSeller(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'required',
            'country'  => 'required',
            'state'    => 'required',
            'skills'   => 'required|array',
            'password' => 'required|min:6',
        ]);

        DB::beginTransaction();
        try {
            $seller = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'mobile'   => $data['mobile'],
                'country'  => $data['country'],
                'state'    => $data['state'],
                'skills'   => implode(',', $data['skills']),
                'role'     => 'seller',
                'password' => Hash::make($data['password']),
            ]);

            DB::commit();
            return response()->json($seller,201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=>'Could not create seller'],500);
        }
    }

    public function listSellers(Request $request)
    {
        $sellers = User::where('role','seller')->paginate(10);
        return response()->json($sellers);
    }
}
