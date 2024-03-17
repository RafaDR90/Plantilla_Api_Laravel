<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:4|max:10|confirmed',
        ]);


        //create user
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->save();
        return response()->json([
            'message' => 'User created successfully'],
            201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);


        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user();

            //comprueba si el usuario tiene un token
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });


            //crear nuevo token
            $token = $user->createToken('token')->accessToken;
            return response()->json([
                'token' => $token,
                'message' => 'Login successful'],
                200);
        } else {
            return response()->json([
                'message' => 'Invalid email or password'],
                401);
        }

    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'data' => $user],
            200);
    }

    public function logout(Request $request)
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout successful'],
            200);
    }
}
