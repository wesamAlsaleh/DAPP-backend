<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Get all drivers
     */
    public function drivers()
    {
        // Get all drivers from the database
        $drivers = User::where('role', 'driver')->get();

        // Return the drivers as JSON
        return response()->json($drivers);
    }
}
