<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationWebController extends Controller
{
    // Explore page with search & filters
    public function explore(Request $request)
    {
        $query = Location::where('status', 'approved')->with('media');

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        if ($rating = $request->query('rating')) {
            $query->where('rating', '>=', (float) $rating);
        }

        // Facility filters
        foreach (['has_toilet', 'has_musholla', 'has_wifi', 'has_camping'] as $facility) {
            if ($request->query($facility)) {
                $query->where($facility, true);
            }
        }

        $locations = $query->orderBy('rating', 'desc')->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.location_cards', compact('locations'))->render(),
                'hasMore' => $locations->hasMorePages()
            ]);
        }

        return view('explore', compact('locations'));
    }

    // Location detail page
    public function show($id)
    {
        $location = Location::with(['media', 'reviews.user'])
            ->withCount('favorites')
            ->findOrFail($id);

        return view('location.detail', compact('location'));
    }

    // Map page
    public function map()
    {
        $locations = Location::where('status', 'approved')->get();
        return view('map', compact('locations'));
    }

    // Show form to create a new location
    public function create()
    {
        // Only creator and admin can post locations
        if (!Auth::user()->canPostLocation()) {
            return redirect()->route('creator.apply')
                ->with('error', 'Kamu harus menjadi Konten Kreator terlebih dahulu untuk menambahkan lokasi.');
        }

        return view('location.create');
    }

    // Store a new location submission
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'address'     => 'required|string|max:500',
            'description' => 'required|string|min:20',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $location = Location::create([
            'user_id'      => Auth::id(),
            'name'         => $request->name,
            'category'     => $request->category,
            'address'      => $request->address,
            'description'  => $request->description,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'rating'       => 0,
            'status'       => 'pending',
            'has_toilet'   => $request->boolean('has_toilet'),
            'has_musholla' => $request->boolean('has_musholla'),
            'has_wifi'     => $request->boolean('has_wifi'),
            'has_camping'  => $request->boolean('has_camping'),
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('locations', 'public');
            Media::create([
                'mediable_id'   => $location->id,
                'mediable_type' => Location::class,
                'path'          => $path,
                'type'          => 'photo',
            ]);
        }

        return redirect()->route('explore')->with('success', 'Terima kasih! Lokasi "' . $location->name . '" berhasil diajukan dan menunggu persetujuan admin.');
    }
}
