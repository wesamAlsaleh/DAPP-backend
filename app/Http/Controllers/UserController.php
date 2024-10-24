<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Update the authenticated user's location.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLocation(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Get the currently authenticated user
        $user = request()->user();

        // Update the user's location
        $user->latitude = $validated['latitude'];
        $user->longitude = $validated['longitude'];
        $user->save();

        // Return a successful response
        return response()->json([
            'status' => 'success',
            'message' => 'User location updated successfully',
        ]);
    }
}
