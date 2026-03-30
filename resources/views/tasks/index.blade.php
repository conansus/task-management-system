@extends('layouts.app')

@section('content')

<h3>All Tasks</h3>

<a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" 
        class="form-control" placeholder="Search...">
    
    <button class="btn btn-secondary">Search</button>

    <a href="{{ route('tasks.index') }}" class="btn btn-danger">
        Reset
    </a>
</form>

<table class="table table-bordered text-center align-middle">
    <tr>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'title','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Title
            </a>
        </th>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'priority','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Priority
            </a>
        </th>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'status','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Status
            </a>
        </th>
        <th>
            <a href="{{ request()->fullUrlWithQuery(['sort'=>'assignedTo','direction'=>request('direction')=='asc'?'desc':'asc']) }}">
                Assigned To
            </a>
        </th>
        <th>Action</th>
    </tr>

    @foreach($tasks as $task)
    <tr>
        <td>{{ $task->title }}</td>
        <td>
            @if($task->priority == 'low')
                <span class="badge bg-success">Low</span>
            @elseif($task->priority == 'medium')
                <span class="badge bg-warning">Medium</span>
            @elseif($task->priority == 'high')
                <span class="badge bg-danger">High</span>
            @else
                <span class="badge bg-secondary">-</span>
            @endif
        </td>
        <td>
            @if($task->status == 'pending')
                <span class="badge bg-warning">Pending</span>
            @elseif($task->status == 'in_progress')
                <span class="badge bg-primary">In Progress</span>
            @elseif($task->status == 'complete')
                <span class="badge bg-success">Complete</span>
            @else
                <span class="badge bg-secondary">Not Assigned</span>
            @endif
        </td>
        <td>{{ $task->assignedTo ? $task->assignedTo->name : '' }}</td> {{-- not all tasks are assigned --}}
        <td>
            <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                <a href="{{ route('tasks.show',$task) }}" class="btn btn-outline-secondary btn-sm">View</a>
                <a href="{{ route('tasks.edit',$task) }}" class="btn btn-outline-primary btn-sm">Edit</a>

                <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy',$task) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-outline-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-task-id="{{ $task->id }}"
                    data-task-title="{{ $task->title }}">
                    Delete
                </button>

                <form action="{{ route('tasks.assign',$task) }}" method="POST" class="d-flex gap-1">
                    @csrf
                    <select name="user_id" class="form-select form-select-sm" style="width: 120px;">
                        <option value="">{{ $task->assignedTo ? 'Unassign' : '-- Assign --' }}</option>
                        @foreach($staff as $s)
                            <option value="{{ $s->id }}" {{ $task->assignedTo?->id == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-primary btn-sm text-nowrap">
                        {{ $task->assignedTo ? 'Reassign' : 'Assign' }}
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>

<div class="mt-3">
    {{ $tasks->links() }}
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteTaskTitle"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    // When the modal is about to be shown, populate it with the correct task info
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
        const trigger = e.relatedTarget;
        const taskId = trigger.getAttribute('data-task-id');
        const taskTitle = trigger.getAttribute('data-task-title');

        document.getElementById('deleteTaskTitle').textContent = taskTitle;

        document.getElementById('confirmDeleteBtn').onclick = function () {
            document.getElementById('delete-form-' + taskId).submit();
        };
    });
</script>

@endsection