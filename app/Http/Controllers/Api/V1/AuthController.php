<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;

class AuthController extends Controller
{
    /**
     * get the request and store the user in the database.
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
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

    public function loginRegisterGuest(Request $request)
    {
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => 'password'
        ];

        $checkAccount = User::where('email', $data['email'])->first();
        if($checkAccount) {
            if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password'] ])){
                return response()->json([
                    'message' => 'Provided email address or password is incorrect'
                ], 401);
            }
            /** @var \App\Models\User $user */ 
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;
            return response()->json(compact('user', 'token'), 200);
        }
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        /** @var \App\Models\User $user */ 
        $token = $user->createToken('main')->plainTextToken;
        return response()->json(compact('user', 'token'), 201);
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

    public function redirectToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'url' => $url
        ]);
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $name = $socialUser->getName();

        // Split the name into separate parts
        $nameParts = explode(' ', $name);
        $firstName = $nameParts[0]; // First name
        $lastName = $nameParts[count($nameParts) - 1]; // Last name

        $user = User::updateOrCreate([
            'provider_id' => $socialUser->getId()
        ],[
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $socialUser->getEmail(),
            'provider' => $provider
        ]);

        /** @var \App\Models\User $user */ 
        $token = $user->createToken('main')->plainTextToken;

        return response()->json(compact('user', 'token'), 201);
    }
}
