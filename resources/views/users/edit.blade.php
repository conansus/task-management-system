@extends('layouts.app')

@section('content')

<h3 class="mb-4">Edit User</h3>

<form method="POST" action="{{ route('users.update',$user) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" value="{{ $user->name }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" value="{{ $user->email }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">New Password (optional)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-control">
            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
            <option value="staff" {{ $user->role=='staff'?'selected':'' }}>Staff</option>
        </select>
    </div>

    <button class="btn btn-primary">Update User</button>
</form>

@endsection