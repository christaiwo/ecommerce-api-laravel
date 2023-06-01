<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * get the request and store the user in the database.
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        /** @var \App\Models\User $user */ 
        $token = $user->createToken('main')->plainTextToken;

        return response()->json(compact('user', 'token'), 201);
    }

    /**
     * get the request and login user
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(!Auth::attempt($data)){
            return response()->json([
                'message' => 'Provided email address or password is incorrect'
            ], 401);
        }

        /** @var \App\Models\User $user */ 
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response()->json(compact('user', 'token'), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        
        /** @var \App\Models\User $user */ 
        $user->currentAccessToken()->delete();
        
        return response()->json([''], 200);
    }

}
