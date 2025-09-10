<x-mail::message>
# Welcome to {{ config('app.name') }}, {{ $user->name }}!

An account has been created for you by an administrator. You can now log in to access the system.

Please use the following temporary password to log in for the first time. You will be required to set a new, secure password immediately after logging in.

**Email:** {{ $user->email }}
**Temporary Password:** `{{ $temporaryPassword }}`

<x-mail::button :url="route('login')">
Click Here to Login
</x-mail::button>

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>