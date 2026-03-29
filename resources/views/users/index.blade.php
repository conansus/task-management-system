@extends('layouts.app')

@section('content')

<h3>Users</h3>

<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add User</a>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
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

@endsection