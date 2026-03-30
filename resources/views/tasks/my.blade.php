@extends('layouts.app')

@section('content')

<h3>My Tasks</h3>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" 
        class="form-control" placeholder="Search...">
    
    <button type="submit" class="btn btn-secondary">Search</button>

    <a href="{{ route('tasks.my') }}" class="btn btn-danger">
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
        <td>
            <div class="d-flex align-items-center justify-content-center gap-1">
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary btn-sm">View</a>

                <form method="POST" action="{{ route('tasks.updateStatus', $task) }}" class="d-flex gap-1">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select form-select-sm" style="width: 120px;">
                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="complete" {{ $task->status == 'complete' ? 'selected' : '' }}>Complete</option>
                    </select>
                    <button class="btn btn-outline-success btn-sm text-nowrap">Update</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach

</table>

<div class="mt-3">
    {{ $tasks->links() }}
</div>

@endsection