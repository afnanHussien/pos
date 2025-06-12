<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login (Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password'=> 'required|string'
        ]);

        $user = User::where(['email'=> $credentials['email'], 'role'=> 'admin'])->first();
        if(!$user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
        $token = $user->createToken('admin');
 
        return response()->json([
            'message' => 'Logged in successfully',
            'token' => $token->plainTextToken,
            'user' => $user,
        ]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
