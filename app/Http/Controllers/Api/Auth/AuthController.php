<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'unique_id' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', '=', $request->input('unique_id'))->OrWhere('unique_id', '=', $request->input('unique_id'))->first();

        if (!$user || !(Hash::check($request->password, $user->password))){
            return response()->json([
                'message' => "Invalid Credentials",
            ], 422);
        }

        $token = $user->createToken('snhapp')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'unique_id' => 'sometimes|nullable|string',
            'email' => 'required|email|unique:users',
            'phone' => 'sometimes|nullable|numeric|min:10',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'unique_id' => $request->input('unique_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('snhapp')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }
}
