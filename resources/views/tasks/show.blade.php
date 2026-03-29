@extends('layouts.app')

@section('content')

<h3>View Task</h3>

<div class="card mb-3">
    <div class="card-header">
        <strong>{{ $task->title }}</strong>
    </div>
    <div class="card-body">
        <p><strong>Description:</strong> {{ $task->description ?? '-' }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
        <p><strong>Status:</strong> 
            @if($task->status == 'pending')
                <span class="badge bg-warning">Pending</span>
            @elseif($task->status == 'in_progress')
                <span class="badge bg-primary">In Progress</span>
            @elseif($task->status == 'complete')
                <span class="badge bg-success">Complete</span>
            @else
                <span class="badge bg-secondary">Not Assigned</span>
            @endif
        </p>
        <p><strong>Assigned To:</strong> {{ $task->assignedTo->name ?? 'Not Assigned' }}</p>
        <p><strong>Assigned By:</strong> {{ $task->assignedBy->name ?? '-' }}</p>
        <p><strong>Created By:</strong> {{ $task->createdBy->name ?? '-' }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date ?? '-' }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ auth()->user()->role == 'admin' ? route('tasks.index') : route('tasks.my') }}" class="btn btn-secondary">Back</a>

        {{-- Only show Edit button for admin --}}
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit</a>
        @endif
    </div>
</div>

@endsection