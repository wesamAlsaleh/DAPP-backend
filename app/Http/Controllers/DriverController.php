<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Get all drivers to display in the drivers list page
     */
    public function allDrivers()
    {
        try {
            // Get all drivers from the database
            $drivers = User::where('role', 'driver')->get();

            // Return the drivers as JSON
            return response()->json($drivers);
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching drivers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the number of available drivers in the system
     */
    public function availableDriversCount()
    {
        try {
            // Get all available drivers from the database
            $drivers = User::where('role', 'driver')->where('status', 'available')->get();

            // Return the number of available drivers
            return response()->json($drivers->count());
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching available drivers count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the available drivers only for the filter
     */
    public function availableDriversFilter()
    {
        try {
            // Get all available drivers from the database
            $drivers = User::where('role', 'driver')->where('status', 'available')->get();

            // Return the available drivers as JSON
            return response()->json($drivers);
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching available drivers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the number of busy drivers in the system
     */
    public function busyDriversCount()
    {
        try {
            // Get all busy drivers from the database
            $drivers = User::where('role', 'driver')->where('status', 'busy')->get();

            // Return the number of busy drivers
            return response()->json($drivers->count());
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching busy drivers count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the busy drivers only for the filter
     */
    public function busyDriversFilter()
    {
        try {
            // Get all busy drivers from the database
            $drivers = User::where('role', 'driver')->where('status', 'busy')->get();

            // Return the busy drivers as JSON
            return response()->json($drivers);
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching busy drivers',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get the number of offline drivers in the system
     */
    public function offlineDriversCount()
    {
        try {
            // Get all offline drivers from the database
            $drivers = User::where('role', 'driver')->where('status', 'offline')->get();

            // Return the number of offline drivers
            return response()->json($drivers->count());
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching offline drivers count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the offline drivers only for the filter
     */
    public function offlineDriversFilter()
    {
        try {
            // Get all offline drivers from the database
            $drivers = User::where('role', 'driver')->where('status', 'offline')->get();

            // Return the offline drivers as JSON
            return response()->json($drivers);
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching offline drivers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single driver
     */
    public function getDriver($id)
    {
        try {
            // Get the driver from the database
            $driver = User::where('role', 'driver')->find($id);

            // Return the driver as JSON
            return response()->json($driver);
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Available and busy drivers
     * To show them on the map
     */
    public function MapDrivers()
    {

        try {
            // Get available and busy drivers from the database
            $drivers = User::where('role', 'driver')
                ->whereIn('status', ['available', 'busy']) // Filter by status if available or busy
                ->get();

            // Return the drivers as JSON
            return response()->json($drivers);
        } catch (\Exception $e) {
            // Handle errors gracefully
            return response()->json([
                'message' => 'Error fetching available and busy drivers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
