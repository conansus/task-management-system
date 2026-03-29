@extends('layouts.app')

@section('content')

<h3>View User</h3>

<div class="card mb-3">
    <div class="card-header">
        <strong>{{ $user->name }}</strong>
    </div>
    <div class="card-body">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p><strong>Created At:</strong> {{ $user->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $user->updated_at->format('d M Y, H:i') }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
    </div>
</div>

@endsection