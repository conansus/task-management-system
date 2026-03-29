<!DOCTYPE html>
<html>
<head>
    <title>
        Task Management
        @auth
            ({{ auth()->user()->role === 'admin' ? 'Admin' : 'Staff' }})
        @endauth
    </title>
    <link rel="icon" href="{{ asset('images/um_no_background.jpg') }}" type="image/jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark navbar-expand-lg shadow-sm">
    <div class="container">
        <div class="navbar-brand fw-bold fs-4" href="#">
            Task System
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('tasks.index') }}" class="nav-link">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">Users</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('tasks.my') }}" class="nav-link">My Tasks</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4" style="max-width: 960px;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            {{ implode('', $errors->all(':message ')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>