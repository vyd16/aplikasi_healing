<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    // List user's itineraries
    public function index(Request $request)
    {
        $itineraries = Itinerary::where('user_id', $request->user()->id)->paginate(10);
        return response()->json($itineraries);
    }

    // Create a new itinerary
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $itinerary = Itinerary::create(array_merge($validated, [
            'user_id' => $request->user()->id,
        ]));

        return response()->json($itinerary, 201);
    }

    // Show a specific itinerary (must belong to user)
    public function show(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with('items.location')
            ->firstOrFail();
        return response()->json($itinerary);
    }

    // Update itinerary
    public function update(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);
        $itinerary->update($validated);
        return response()->json($itinerary);
    }

    // Delete itinerary
    public function destroy(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $itinerary->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
?>
