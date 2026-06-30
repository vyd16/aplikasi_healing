<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    // List locations with optional search & filters (simplified)
    public function index(Request $request)
    {
        $query = Location::query();

        if ($search = $request->query('q')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        // Additional filters (rating, distance, facilities) can be added later
        $locations = $query->paginate(12);
        return response()->json($locations);
    }

    // Show a single location with relations
    public function show($id)
    {
        $location = Location::with(['reviews.user', 'media'])->findOrFail($id);
        return response()->json($location);
    }
}
?>
