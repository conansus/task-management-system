@extends('layouts.app')

@section('content')

<h3>All Tasks</h3>

<a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>

<table class="table table-bordered text-center align-middle">
    <tr>
        <th>Title</th>
        <th>Priority</th>
        <th>Status</th>
        <th>Assigned To</th>
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

                <form action="{{ route('tasks.destroy',$task) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </form>

                <form action="{{ route('tasks.assign',$task) }}" method="POST" class="d-flex gap-1">
                    @csrf
                    <select name="user_id" class="form-select form-select-sm" style="width: 120px;">
                        <option value="">-- Assign --</option>
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

@endsection