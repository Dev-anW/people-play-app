<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\UserChangeRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's own profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $interests = Interest::all();
        $userInterests = $user->interests->pluck('id')->toArray();

        return view('profile.edit', compact('user', 'interests', 'userInterests'));
    }

    /**
     * Update request for user's own profile in storage.
     */
    public function update(UpdateProfileRequest $request)
{
    $user = Auth::user();

  
    $user->interests()->sync($request->input('interests', []));

   
    $validatedData = $request->validated();
    
    unset($validatedData['interests']);

    
    UserChangeRequest::create([
        'user_id' => $user->id,
        'requested_data' => $validatedData,
    ]);

    return redirect()->route('profile.edit')
                     ->with('success', 'Your change request has been submitted for admin approval. Your interests have been updated immediately.');
}
}
