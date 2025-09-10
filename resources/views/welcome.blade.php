<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ProPay People Play') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        
        #bg-video {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -100;
            transform: translateX(-50%) translateY(-50%);
            object-fit: cover; 
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 33, 47, 0.7); 
            z-index: -99;
        }
        


        body {
            font-family: 'Figtree', sans-serif;
            
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden; 
        }
        .container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
            
            position: relative;
            z-index: 10;
        }
        .logo {
            max-width: 250px; 
            height: auto;     
            margin: 0 auto 2rem;
        }
        .title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .accent-text {
            color: #294858; 
        }
        .description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 2.5rem;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            min-width: 250px;
            transition: background-color 0.3s ease;
        }
        .btn-primary {
            background-color: #294858; 
            color: white;
        }
        .btn-primary:hover {
            background-color: #3b6275;
        }
        .btn-secondary {
            background-color: white;
            color: #294858;
            border: 2px solid #294858;
        }
         .btn-secondary:hover {
            background-color: #c9c9c9ff;
        }
    </style>
</head>
<body>
   
    <video playsinline autoplay muted loop id="bg-video">
        <source src="https://propay.co.za/wp-content/uploads/2024/08/Sequence-01.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

   
    <div class="overlay"></div>

    
    <div class="container">
        <img src="{{ asset('images/propay-sa-trim-300.png') }}" alt="Propay Logo" class="logo">

        <h1 class="title">ProPay <span class="accent-text">People Play</span></h1>
        <p class="description">
            The all in one tech platform, for admins, users and learning about DEVAN WOLLENSCHLAEGER - to a limited extent.
        </p>

        <h2 class="subtitle">Select Your Action</h2>

        <div class="btn-group">
    @guest
        {{-- This content is for non-logged-in users ONLY --}}
        <a href="{{ route('login') }}" class="btn btn-primary">Login as Admin</a>
        <a href="{{ route('login') }}" class="btn btn-primary">Login as User</a>
        <a href="{{ route('developer') }}" class="btn btn-secondary">Learn About The Developer</a>
    @endguest

    @auth
        {{-- This content is for logged-in users ONLY --}}
        <a href="{{ route('home') }}" class="btn btn-primary">Go to My Dashboard</a>

       
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <a href="{{ route('logout') }}"
               class="btn btn-secondary"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </form>
    @endauth
</div>
    </div>
</body>
</html>
