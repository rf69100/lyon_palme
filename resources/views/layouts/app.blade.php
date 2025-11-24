<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Lyon Palme</title>
    @vite(['resources/css/app.css'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        nav {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        nav .container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4338ca;
        }
        nav form button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
        }
        nav form button:hover {
            background: #b91c1c;
        }
        main {
            max-width: 1280px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <h1>🏊 Lyon Palme</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
