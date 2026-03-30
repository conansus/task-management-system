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
            <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary btn-sm">View</a>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">Edit</a>

                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-outline-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-user-id="{{ $user->id }}"
                    data-user-name="{{ $user->name }}">
                    Delete
                </button>
            </div>
        </td>
    </tr>
    @endforeach

</table>

<div class="mt-3">
    {{ $users->links() }}
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteUserName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    // When the modal is shown, populate it with the correct user info
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
        const trigger = e.relatedTarget;
        const userId = trigger.getAttribute('data-user-id');
        const userName = trigger.getAttribute('data-user-name');

        document.getElementById('deleteUserName').textContent = userName;

        document.getElementById('confirmDeleteBtn').onclick = function () {
            document.getElementById('delete-form-' + userId).submit();
        };
    });
</script>

@endsection