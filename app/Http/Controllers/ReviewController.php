<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Store a new review for a location (auth required)
    public function store(Request $request, $locationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $location = Location::findOrFail($locationId);

        $data = [
            'user_id' => $request->user()->id,
            'location_id' => $location->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        // Handle optional photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('review_photos', 'public');
            $data['photo_path'] = $path;
        }

        $review = Review::create($data);

        // Recalculate location average rating
        $avg = Review::where('location_id', $location->id)->avg('rating');
        $location->rating = $avg;
        $location->save();

        return response()->json($review, 201);
    }
}
?>
