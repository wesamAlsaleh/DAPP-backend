<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a user.
     */
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
    }

    /**
     * Log in a user.
     */
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get the user from the database based on the email address
        $user = User::where('email', $request->email)->first();

        // If the user not exists or the password is wrong, return an error
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Return the user token as a response
        return response()->json([
            'token' => $user->createToken($request->email)->plainTextToken, // required
            // 'user' => $user, // optional
        ]);
    }

    /**
     * Log out a user.
     */
    public function logout(Request $request)
    {
        //
    }
}
