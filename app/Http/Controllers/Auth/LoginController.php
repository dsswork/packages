<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('login token');
            return [
                'status' => 'success',
                'token' => $token->plainTextToken
            ];
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email or password invalid'
        ], 401);
    }
}
