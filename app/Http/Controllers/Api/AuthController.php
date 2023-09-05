<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user_id' => $user->id,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role_id' => $user->role_id
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $roleId = Auth::user()->role_id;
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user_id' => $user->id,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role_id' => $roleId
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
