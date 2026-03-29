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
            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">View</a>
            <a href="{{ route('users.edit',$user) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('users.destroy',$user) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection