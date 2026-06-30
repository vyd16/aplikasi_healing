<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteWebController extends Controller
{
    // Show user's favorites
    public function index(Request $request)
    {
        $favorites = Favorite::where('user_id', $request->user()->id)
            ->with('location')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favorites', compact('favorites'));
    }

    // Toggle favorite (add or remove)
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
        ]);

        $existing = Favorite::where('user_id', $request->user()->id)
            ->where('location_id', $request->location_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Lokasi dihapus dari favorit.');
        }

        Favorite::create([
            'user_id' => $request->user()->id,
            'location_id' => $request->location_id,
        ]);

        return back()->with('success', 'Lokasi ditambahkan ke favorit!');
    }
}
