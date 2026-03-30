@extends('layouts.app')

@section('content')

<h3>Users</h3>

<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add User</a>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" 
        class="form-control" placeholder="Search...">
    
    <button type="submit" class="btn btn-secondary">Search</button>

    <a href="{{ route('users.index') }}" class="btn btn-danger">
        Reset
    </a>
</form>

<table class="table table-bordered text-center align-middle">
    <tr>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'name','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Name
            </a>
        </th>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'email','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Email
            </a>
        </th>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'role','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Role
            </a>
        </th>
        <th>Action</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ strtoupper($user->role) }}</td>
        <td>
            <div class="d-flex gap-1">
                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary btn-sm">View</a>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">Edit</a>

                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach

</table>

<div class="mt-3">
    {{ $users->links() }}
</div>

@endsection