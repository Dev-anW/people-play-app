<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordCreationController extends Controller
{
    public function create()
    {
        return view('password.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now(); // Mark the user as verified!
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully! You can now manage your profile.');
}
}