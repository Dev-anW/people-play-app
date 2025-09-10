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
    
    $query = User::query()->where('is_admin', false);

    
    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('surname', 'LIKE', "%{$searchTerm}%")
              ->orWhere('email', 'LIKE', "%{$searchTerm}%");
        });
    }

   
    if ($request->filled('interest_id')) {
        $query->whereHas('interests', function ($q) use ($request) {
            $q->where('interests.id', $request->input('interest_id'));
        });
    }

   
    if ($request->filled('verified')) {
        if ($request->input('verified') == '1') {
            $query->whereNotNull('email_verified_at');
        } else {
            $query->whereNull('email_verified_at'); 
        }
    }

   
    if ($request->filled('sort')) {
        $sort = $request->input('sort');
        if ($sort == 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort == 'name_desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort == 'age_asc') {
            $query->orderBy('birth_date', 'desc');
        } elseif ($sort == 'age_desc') { 
            $query->orderBy('birth_date', 'asc');
        }
    } else {
        
        $query->latest();
    }

    
    $interests = Interest::orderBy('name')->get();

    
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
            
            $temporaryPassword = Str::random(8);

            $userData = $request->validated();
            $userData['password'] = Hash::make($temporaryPassword);

            $user = User::create($userData);

            
            $user->interests()->sync($request->input('interests', []));

            
            Mail::to($user->email)->send(new NewUserWelcomeMail($user, $temporaryPassword));

          
        });

       
        return redirect()->route('users.index')
                         ->with('success', 'User created successfully and welcome email sent.');

    } catch (Exception $e) {
        
        Log::error('Failed to create new user: ' . $e->getMessage());

        
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
