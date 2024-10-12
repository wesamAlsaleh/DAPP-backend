<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a user.
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            // User Fields
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',      // Must contain letters
                'regex:/[0-9]/',         // Must contain numbers
                'regex:/[@$!%*#?&]/',    // Must contain special characters
            ],
        ], [
            'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]);

        try {
            // Create a new user with the validated data
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Return a success response with selected user data and token
            return response()->json([
                'token' => $user->createToken('API Token of ' . $user->email)->plainTextToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User registration failed. Please try again.',
            ], 500);
        }
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
            'token' => $user->createToken('API Token of ' . $request->email)->plainTextToken, // required
            // 'user' => $user, // optional
        ], 200);
    }

    /**
     * Log out a user.
     */
    public function logout(Request $request)
    {
        // Revoke the current user token and delete it
        request()->user()->currentAccessToken()->delete();

        // Return a no content response with 204 status code (success)
        return response()->noContent();
    }
}
