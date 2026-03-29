@extends('layouts.app')

@section('content')

<h3>My Tasks</h3>

<table class="table table-bordered">
    <tr>
        <th>Title</th>
        <th>Priority</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($tasks as $task)
    <tr>
        <td>{{ $task->title }}</td>
        <td>{{ strtoupper($task->priority) }}</td>
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

        <td>
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">View</a>
            <form method="POST" action="{{ route('tasks.updateStatus',$task) }}">
                @csrf
                @method('PATCH')

                <select name="status" class="form-control mb-1">
                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="complete" {{ $task->status == 'complete' ? 'selected' : '' }}>Complete</option>
                </select>

                <button class="btn btn-success btn-sm">Update</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection