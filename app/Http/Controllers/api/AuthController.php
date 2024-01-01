<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email"=> ['required','email'],
            'password' => ['required'],
            'remember' => ['boolean']
        ]);


        $remember = $credentials['remember'] ?? false;

        unset($credentials['remember']);

        if(!Auth::attempt($credentials)) 
        {
            return response()->json(['success'=>false,'message'=> 'Credentials do not match!'],422);
        }

        $user = Auth::user();

        if(isset($user) && !$user->is_admin)
        {
            Auth::logout();
            return response()->json(['success'=>false,'message'=> 'You dont have a permission to login as admin']);            
        }

        $token = $user->createToken('main')->plainTextToken;
        
        return response()->json([
            'success'=>true,
            'token' =>$token,
            'user'=>$user
        ]);
    }


    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'success'=>true
        ]);
    }
}
