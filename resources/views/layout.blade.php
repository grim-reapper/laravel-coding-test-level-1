<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-between">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                @auth()
                <li><a href="{{route('events.index')}}" class="nav-link px-2 text-white">Events</a></li>
                <li><a href="{{route('posts')}}" class="nav-link px-2 text-white">Posts</a></li>
                @endauth
            </ul>
            <div class="text-end">
                @auth()
                    <a href="{{route('logout')}}" type="button" class="btn btn-warning">Logout</a>
                @endauth
                @guest()
                        <a href="{{route('login')}}" type="button" class="btn btn-outline-light me-2">Login</a>
                        <a href="{{route('register')}}" type="button" class="btn btn-outline-light me-2">Register</a>
                    @endguest
            </div>
        </div>
    </div>
</header>
<div class="container">
    @auth()
        <p class="mt-3">Welcome, {{auth()->user()->name}}</p>
    @endauth
    @yield('content')
</div>
</body>
</html>
