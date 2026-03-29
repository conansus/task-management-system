@extends('layouts.app')

@section('content')

<h3>Create User</h3>

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <input name="name" class="form-control mb-2" placeholder="Name">
    <input name="email" class="form-control mb-2" placeholder="Email">

    <input type="password" name="password" class="form-control mb-2" placeholder="Password">
    <input type="password" name="password_confirmation" class="form-control mb-2" placeholder="Confirm Password">

    <select name="role" class="form-control mb-2">
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
    </select>

    <button class="btn btn-success">Save</button>
</form>

@endsection