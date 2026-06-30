<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Location;
use Illuminate\Http\Request;

class ReviewWebController extends Controller
{
    // Store a review from the web form
    public function store(Request $request, $locationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        $location = Location::findOrFail($locationId);

        $data = [
            'user_id' => $request->user()->id,
            'location_id' => $location->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('review_photos', 'public');
        }

        Review::create($data);

        // Recalculate average rating
        $location->rating = Review::where('location_id', $location->id)->avg('rating');
        $location->save();

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }
}
