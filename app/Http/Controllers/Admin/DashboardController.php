<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreatorApplication;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Admin dashboard with stats
    public function index()
    {
        $totalLocations = Location::count();
        $pendingLocations = Location::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $totalReviews = Review::count();
        $totalUsers = User::count();
        $recentReviews = Review::with('user', 'location')->orderBy('created_at', 'desc')->take(10)->get();

        // Creator applications
        $pendingCreators = CreatorApplication::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalLocations',
            'pendingLocations',
            'totalReviews',
            'totalUsers',
            'recentReviews',
            'pendingCreators'
        ));
    }

    // Approve a pending location
    public function approveLocation(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->status = 'approved';
        $location->save();

        // Send notification to the user who submitted this location
        if ($location->user_id) {
            Notification::create([
                'user_id' => $location->user_id,
                'type'    => 'location_approved',
                'data'    => [
                    'message'     => 'Lokasi "' . $location->name . '" yang kamu ajukan telah disetujui! Sekarang sudah bisa dilihat di halaman Jelajahi.',
                    'location_id' => $location->id,
                    'icon'        => 'check_circle',
                ],
            ]);
        }

        return back()->with('success', 'Lokasi "' . $location->name . '" berhasil disetujui!');
    }

    // Approve a creator application
    public function approveCreator($id)
    {
        $application = CreatorApplication::findOrFail($id);
        $application->status = 'approved';
        $application->save();

        // Upgrade user role to creator
        $application->user->update(['role' => 'creator']);

        // Send notification
        Notification::create([
            'user_id' => $application->user_id,
            'type'    => 'creator_approved',
            'data'    => [
                'message' => 'Selamat! 🎉 Pengajuan Konten Kreator kamu telah disetujui. Sekarang kamu bisa menambahkan lokasi healing baru!',
                'icon'    => 'check_circle',
            ],
        ]);

        return back()->with('success', 'Kreator "' . $application->user->name . '" berhasil disetujui!');
    }

    // Reject a creator application
    public function rejectCreator(Request $request, $id)
    {
        $application = CreatorApplication::findOrFail($id);
        $application->status = 'rejected';
        $application->admin_notes = $request->input('admin_notes', 'Pengajuan tidak memenuhi persyaratan.');
        $application->save();

        // Send notification
        Notification::create([
            'user_id' => $application->user_id,
            'type'    => 'creator_rejected',
            'data'    => [
                'message' => 'Maaf, pengajuan Konten Kreator kamu belum bisa disetujui saat ini. Alasan: ' . $application->admin_notes,
                'icon'    => 'info',
            ],
        ]);

        return back()->with('success', 'Pengajuan kreator "' . $application->user->name . '" ditolak.');
    }
}
