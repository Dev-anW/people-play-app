<?php

namespace App\Http\Controllers;

use App\Models\UserChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChangeRequestController extends Controller
{
    public function index()
    {
        $pendingRequests = UserChangeRequest::with('user')->where('status', 'pending')->get();
        $historicalRequests = UserChangeRequest::with('user', 'reviewer')->whereIn('status', ['approved', 'rejected'])->latest()->paginate(10);

        return view('admin.requests.index', compact('pendingRequests', 'historicalRequests'));
    }

    public function approve(UserChangeRequest $request)
    {
        $user = $request->user;

        // Loop through the requested data and update the user model
        foreach ($request->requested_data as $field => $value) {
            $user->{$field} = $value;
        }
        $user->save();

        // Update the request status
        $request->status = 'approved';
        $request->reviewed_by = Auth::id();
        $request->reviewed_at = now();
        $request->save();

        return redirect()->route('admin.requests.index')->with('success', 'Change request approved and user profile updated.');
    }

    public function reject(UserChangeRequest $request)
    {
        $request->status = 'rejected';
        $request->reviewed_by = Auth::id();
        $request->reviewed_at = now();
        $request->save();

        return redirect()->route('admin.requests.index')->with('success', 'Change request rejected.');
    }
}