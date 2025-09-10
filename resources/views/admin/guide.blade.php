@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Admin Guide</h4>
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    <h1>Welcome to People Play! - User Guide</h1>
<p>Welcome to the People Play application! This platform is designed to securely manage user profiles through a system of direct administration and user-submitted change requests.<br><br>Your experience will differ based on your assigned role. Please find the guide for your specific role below.</p>
<hr>

<h2>1. Admin Guide</h2>
<p>As an Administrator, you have full control over the user database. Your primary responsibilities are to manage the user lifecycle (creating, editing, deleting) and to review and process change requests submitted by users.</p>

<h3>Logging In</h3>
<p>You log in using the same login screen as a regular user. Your admin status is automatically detected, granting you access to the administrative dashboard.</p>

<h3>The Admin Dashboard</h3>
<p>Your dashboard is your command center. It is divided into two columns:</p>
<ul>
    <li><strong>Left Column:</strong>
        <ul>
            <li><strong>Admin Tools:</strong> This is your main operational panel. The "Go to User Management" button takes you to the central user list.</li>
            <li><strong>Admin Guide:</strong> Contains a button that links to a more detailed guide page (like this one) explaining the application's features.</li>
        </ul>
    </li>
    <br>
    <li><strong>Right Column:</strong>
        <ul>
            <li><strong>Admin Account Details:</strong> A quick-view card displaying your own profile information for reference.</li>
            <li><strong>User Detail Changes:</strong> This is a critical widget. It shows a live count of how many user-submitted profile changes are waiting for your review. If the count is greater than zero, it's a call to action.</li>
        </ul>
    </li>
</ul>

<h3>Managing Users</h3>
<p>Accessed via the "Go to User Management" button, this screen is where you will perform most of your duties.</p>
<ul>
    <li><strong>Search and Filter Bar:</strong>
        <ul>
            <li><strong>Search:</strong> A text field to instantly search for users by their Name, Surname, or Email.</li>
            <li><strong>Filters:</strong> Powerful dropdowns to narrow down the user list by their <strong>Interests</strong>, account <strong>Status</strong> (Verified/Unverified), or to <strong>Sort</strong> the list alphabetically or by age.</li>
            <li><strong>Clear Button:</strong> A handy link to reset all filters and view the complete user list again.</li>
        </ul>
    </li>
    <br>
    <li><strong>User Actions:</strong>
        <ul>
            <li><strong>Create New User:</strong> Clicking this button opens a form to add a new person to the system. When you submit this form, a welcome email is automatically sent to the user with a randomly generated temporary password, instructing them on how to log in for the first time.</li>
            <li><strong>View:</strong> (Primary Color Text) A read-only look at a user's full profile details.</li>
            <li><strong>Edit:</strong> (Black Text) This allows you to <strong>directly and immediately</strong> change a user's information. Changes made here do not go through the approval process. This is for administrative corrections.</li>
            <li><strong>Delete:</strong> (Red Text) Permanently removes the user and all their associated data from the system. This action is irreversible.</li>
        </ul>
    </li>
</ul>

<h3>Reviewing User Change Requests</h3>
<p>This is the second core function of an admin.</p>
<ol>
    <li><strong>Accessing the Queue:</strong> From the dashboard, click the "Review Requests" button on the "User Detail Changes" card.</li>
    <br>
    <li><strong>The Review Screen:</strong> This page is split into two sections:
        <ul>
            <li><strong>Pending Approval:</strong> This is your to-do list. Each pending request is displayed clearly, showing the user's <strong>Current Info</strong> side-by-side with their <strong>Requested Info</strong>.</li>
            <li><strong>Approve/Reject Buttons:</strong>
                <ul>
                    <li><strong>Approve:</strong> Clicking this will instantly update the user's profile with the new information they requested. The request is then moved to the history log.</li>
                    <li><strong>Reject:</strong> Clicking this will discard the user's request. Their profile information remains unchanged. The request is then moved to the history log.</li>
                </ul>
            </li>
            <li><strong>Request History:</strong> A table at the bottom of the page showing a log of all previously approved or rejected requests, including which admin reviewed them and when.</li>
        </ul>
    </li>
</ol>
<hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection