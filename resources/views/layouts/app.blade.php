<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand">Task System</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">

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
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ implode('', $errors->all(':message ')) }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>