<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Approve a pending location (admin only)
    public function approve(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->status = 'approved';
        $location->save();
        return response()->json(['message' => 'Location approved'], 200);
    }
}
?>
