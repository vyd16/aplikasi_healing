<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\ItineraryItem;
use App\Models\Location;
use Illuminate\Http\Request;

class ItineraryWebController extends Controller
{
    // List user's itineraries
    public function index(Request $request)
    {
        $itineraries = Itinerary::where('user_id', $request->user()->id)
            ->withCount('items')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('itineraries.index', compact('itineraries'));
    }

    // Store a new itinerary
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

        return redirect('/itineraries/' . $itinerary->id)->with('success', 'Trip berhasil dibuat!');
    }

    // Show itinerary detail
    public function show(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['items.location'])
            ->firstOrFail();

        // Get all approved locations for the "Add Destination" modal
        $locations = Location::where('status', 'approved')
            ->orderBy('name')
            ->select('id', 'name', 'category', 'address')
            ->get();

        // Calculate trip duration in days
        $startDate = \Carbon\Carbon::parse($itinerary->start_date);
        $endDate = \Carbon\Carbon::parse($itinerary->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // Group items by day_number
        $itemsByDay = $itinerary->items->groupBy('day_number');

        return view('itineraries.show', compact('itinerary', 'locations', 'totalDays', 'itemsByDay'));
    }

    // Add an item to itinerary
    public function addItem(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validated = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'day_number' => 'required|integer|min:1',
        ]);

        // Get the next order number for this day
        $maxOrder = ItineraryItem::where('itinerary_id', $itinerary->id)
            ->where('day_number', $validated['day_number'])
            ->max('order') ?? 0;

        ItineraryItem::create([
            'itinerary_id' => $itinerary->id,
            'location_id' => $validated['location_id'],
            'day_number' => $validated['day_number'],
            'order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Destinasi berhasil ditambahkan!');
    }

    // Remove an item from itinerary
    public function removeItem(Request $request, $itemId)
    {
        $item = ItineraryItem::findOrFail($itemId);

        // Verify ownership
        $itinerary = Itinerary::where('id', $item->itinerary_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Destinasi berhasil dihapus.');
    }

    // Reorder items via AJAX (drag-and-drop)
    public function reorderItems(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:itinerary_items,id',
            'items.*.order' => 'required|integer|min:1',
            'items.*.day_number' => 'required|integer|min:1',
        ]);

        foreach ($validated['items'] as $itemData) {
            ItineraryItem::where('id', $itemData['id'])
                ->where('itinerary_id', $itinerary->id)
                ->update([
                    'order' => $itemData['order'],
                    'day_number' => $itemData['day_number'],
                ]);
        }

        return response()->json(['success' => true]);
    }

    // Generate share link
    public function share(Request $request, $id)
    {
        $itinerary = Itinerary::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (!$itinerary->share_token) {
            $itinerary->generateShareToken();
        }

        $shareUrl = url('/trip/' . $itinerary->share_token);

        return back()->with('share_url', $shareUrl);
    }

    // Public shared trip view (no auth required)
    public function sharedView($token)
    {
        $itinerary = Itinerary::where('share_token', $token)
            ->with(['user', 'items.location'])
            ->firstOrFail();

        $startDate = \Carbon\Carbon::parse($itinerary->start_date);
        $endDate = \Carbon\Carbon::parse($itinerary->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $itemsByDay = $itinerary->items->groupBy('day_number');

        return view('itineraries.shared', compact('itinerary', 'totalDays', 'itemsByDay'));
    }
}
