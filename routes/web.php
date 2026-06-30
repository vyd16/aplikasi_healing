<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\LocationWebController;
use App\Http\Controllers\ReviewWebController;
use App\Http\Controllers\FavoriteWebController;
use App\Http\Controllers\ItineraryWebController;
use App\Http\Controllers\NotificationWebController;
use App\Http\Controllers\CreatorApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Location;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ---- Public Routes ----

// Home page
Route::get('/', function () {
    $popularLocations = Location::where('status', 'approved')
        ->with('media')
        ->orderBy('rating', 'desc')
        ->take(8)
        ->get();
    $mapLocations = Location::where('status', 'approved')
        ->select('id', 'name', 'latitude', 'longitude', 'category', 'rating')
        ->get();
    return view('home', compact('popularLocations', 'mapLocations'));
});


// Explore / Search
Route::get('/explore', [LocationWebController::class, 'explore'])->name('explore');

// Location detail
Route::get('/location/{id}', [LocationWebController::class, 'show'])->name('location.show');

// Map page
Route::get('/map', [LocationWebController::class, 'map'])->name('map');

// FAQ page
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// ---- Auth Routes (Guest Only) ----
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthWebController::class, 'login']);
    Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthWebController::class, 'register']);
});

// ---- Auth Routes (Logged In) ----
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

    // Favorites
    Route::get('/favorites', [FavoriteWebController::class, 'index'])->name('favorites');
    Route::post('/favorites', [FavoriteWebController::class, 'store']);

    // Reviews
    Route::post('/location/{id}/review', [ReviewWebController::class, 'store']);

    // Itineraries (Trip Planner)
    Route::get('/itineraries', [ItineraryWebController::class, 'index'])->name('itineraries');
    Route::post('/itineraries', [ItineraryWebController::class, 'store']);
    Route::get('/itineraries/{id}', [ItineraryWebController::class, 'show'])->name('itineraries.show');
    Route::post('/itineraries/{id}/items', [ItineraryWebController::class, 'addItem'])->name('itineraries.addItem');
    Route::delete('/itineraries/items/{itemId}', [ItineraryWebController::class, 'removeItem'])->name('itineraries.removeItem');
    Route::put('/itineraries/{id}/reorder', [ItineraryWebController::class, 'reorderItems'])->name('itineraries.reorder');
    Route::post('/itineraries/{id}/share', [ItineraryWebController::class, 'share'])->name('itineraries.share');

    // Submit new location (creator/admin only — enforced in controller)
    Route::get('/location-create', [LocationWebController::class, 'create'])->name('location.create');
    Route::post('/location-create', [LocationWebController::class, 'store'])->name('location.store');

    // Creator application (upgrade akun)
    Route::get('/creator/apply', [CreatorApplicationController::class, 'showForm'])->name('creator.apply');
    Route::post('/creator/apply', [CreatorApplicationController::class, 'apply'])->name('creator.submit');

    // Notifications
    Route::get('/notifications', [NotificationWebController::class, 'index'])->name('notifications');
    Route::put('/notifications/{id}/read', [NotificationWebController::class, 'markAsRead'])->name('notifications.read');
    Route::put('/notifications/read-all', [NotificationWebController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Profile & Settings
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings');
});

// ---- Public Shared Trip ----
Route::get('/trip/{token}', [ItineraryWebController::class, 'sharedView'])->name('trip.shared');

// ---- Admin Routes ----
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::put('/locations/{id}/approve', [DashboardController::class, 'approveLocation']);
    Route::put('/creators/{id}/approve', [DashboardController::class, 'approveCreator'])->name('admin.creator.approve');
    Route::put('/creators/{id}/reject', [DashboardController::class, 'rejectCreator'])->name('admin.creator.reject');
});

// Temporary secure route to run seeding in Vercel environment
Route::get('/run-seeding-prod', function () {
    if (request('key') !== 'healpoint_secure_token_123') {
        abort(403);
    }
    
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

