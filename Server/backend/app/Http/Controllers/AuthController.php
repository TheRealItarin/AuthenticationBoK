<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $user = new User;
            $user->username = $request->input('username');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response()->json(['success' => 'Successfully registered!'], 201);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();
        if ($user && $this->isPasswordCorrect($user, $request)) {
            if (Hash::needsRehash($user->password)) {
                $user->password = Hash::make($request->input('password'));
                $user->save();
            }
            $user->tokens()->delete();
            $abilities = ['role:'.$user->role];
            $token = $user->createToken('auth_token', $abilities)->plainTextToken;

            return response()->json([
                'token' => $token,
                'username' => $user->username,
                'role' => $user->role,
            ], 200);
        } else {
            return response()->json(['unauthorized' => 'Wrong username or password'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();
        if ($user) {
            $user->tokens()->delete();

            return response()->json(['success' => 'Successfully logged out'], 200);
        } else {
            return response()->json(['unauthorized' => 'User not found'], 401);
        }
    }

    protected function isPasswordCorrect(User $user, Request $request)
    {
        return password_verify($request->input('password'), $user->password);
    }

    private function getValidationRules()
    {
        return [
            'username' => 'required|unique:users|max:255',
            'password' => [
                'required',
                'string',
                Password::min(15)
                    ->max(64)
                    ->uncompromised(),
            ],
        ];
    }
}
