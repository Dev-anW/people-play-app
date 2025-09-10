<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Interest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserWelcomeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Start building the query for non-admin users
    $query = User::query()->where('is_admin', false);

    // 1. Handle the search functionality
    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('surname', 'LIKE', "%{$searchTerm}%")
              ->orWhere('email', 'LIKE', "%{$searchTerm}%");
        });
    }

    // 2. Handle filtering by interest
    if ($request->filled('interest_id')) {
        $query->whereHas('interests', function ($q) use ($request) {
            $q->where('interests.id', $request->input('interest_id'));
        });
    }

    // 3. Handle filtering by verified status
    if ($request->filled('verified')) {
        if ($request->input('verified') == '1') {
            $query->whereNotNull('email_verified_at'); // Verified users
        } else {
            $query->whereNull('email_verified_at'); // Unverified users
        }
    }

    // 4. Handle sorting options
    if ($request->filled('sort')) {
        $sort = $request->input('sort');
        if ($sort == 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort == 'name_desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort == 'age_asc') { // Youngest first
            $query->orderBy('birth_date', 'desc');
        } elseif ($sort == 'age_desc') { // Oldest first
            $query->orderBy('birth_date', 'asc');
        }
    } else {
        // Default sort if nothing is selected
        $query->latest();
    }

    // Fetch all interests for the filter dropdown
    $interests = Interest::orderBy('name')->get();

    // Paginate the results and append the query string to the links
    $users = $query->paginate(10)->withQueryString();

    return view('users.index', compact('users', 'interests'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interests = Interest::all();
        return view('users.create', compact('interests'));
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(StoreUserRequest $request)
    {
    try {
        DB::transaction(function () use ($request) {
            // 1. Generate a random 8-character password
            $temporaryPassword = Str::random(8);

            // 2. Get validated data and add the hashed password
            $userData = $request->validated();
            $userData['password'] = Hash::make($temporaryPassword);

            // 3. Create the user IN THE TRANSACTION
            $user = User::create($userData);

            // 4. Sync interests IN THE TRANSACTION
            $user->interests()->sync($request->input('interests', []));

            // 5. Attempt to send the welcome email
            // If THIS line fails, it will throw an exception.
            Mail::to($user->email)->send(new NewUserWelcomeMail($user, $temporaryPassword));

            // If the code reaches here, it means the user was created AND
            // the email was sent successfully. The transaction will be automatically committed.
        });

        // If the transaction completes without errors, redirect with success message.
        return redirect()->route('users.index')
                         ->with('success', 'User created successfully and welcome email sent.');

    } catch (Exception $e) {
        // If any exception occurred (e.g., mail server is down, wrong credentials)

        // 1. Log the detailed error for the developer to see.
        // This is crucial for debugging! Check your storage/logs/laravel.log file.
        Log::error('Failed to create new user: ' . $e->getMessage());

        // 2. Redirect the admin back to the form with an error message.
        // The database transaction has already been automatically rolled back.
        // withInput() repopulates the form with the data the admin already entered.
        return redirect()->back()
                         ->with('error', 'Failed to create user. Could not send welcome email. Please check mail configuration and try again.')
                         ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Eager load the interests to prevent extra database queries
        $user->load('interests');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $interests = Interest::all();
        $userInterests = $user->interests->pluck('id')->toArray();
        return view('users.edit', compact('user', 'interests', 'userInterests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Validation is handled by UpdateUserRequest
        // Note: We are not updating the password here, which is standard
        // for an admin panel. A password reset flow is a separate feature.
        $user->update($request->validated());
        $user->interests()->sync($request->input('interests', []));

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}