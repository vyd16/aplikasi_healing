<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Show the profile and settings editing page
    public function show()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    // Handle updating profile details (name, email, password)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required_with:new_password|nullable|string',
            'new_password'     => 'nullable|string|confirmed|min:8',
        ], [
            'current_password.required_with' => 'Password lama wajib diisi jika ingin mengganti password baru.',
            'new_password.min'               => 'Password baru minimal 8 karakter.',
            'new_password.confirmed'         => 'Konfirmasi password baru tidak cocok.',
        ]);

        // If trying to change password
        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama yang dimasukkan salah.'])->withInput();
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Handle updating settings (locale, distance_unit)
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'locale'        => 'required|string|in:id,en',
            'distance_unit' => 'required|string|in:km,mil',
        ]);

        session([
            'locale'        => $validated['locale'],
            'distance_unit' => $validated['distance_unit'],
        ]);

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
