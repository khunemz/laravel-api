<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function register(Request $request) {
        try {
            $fields = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|confirmed|max:255'
            ]);

            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
            ]);
            $token = $user->createToken(env('APP_KEY'))->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255'
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'The provided credentials are incorrect.',
                401
            ]);
        }

        $token = $user->createToken(env('APP_KEY'))->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 200);
    }

    public function logout(Request $request) {
        // the `tokens` is defined in Sanctum method
        auth()?->user()?->tokens()->delete();
        return [
            'message' => 'Logged out successfully'
        ];
    }
}
