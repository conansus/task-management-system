@extends('layouts.app')

@section('content')

<h3 class="mb-4">Edit Task</h3>

<form method="POST" action="{{ route('tasks.update',$task) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" value="{{ $task->title }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ $task->description }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-control">
            <option value="low" {{ $task->priority=='low'?'selected':'' }}>Low</option>
            <option value="medium" {{ $task->priority=='medium'?'selected':'' }}>Medium</option>
            <option value="high" {{ $task->priority=='high'?'selected':'' }}>High</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" value="{{ $task->due_date }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="not_assigned" {{ $task->status=='not_assigned'?'selected':'' }}>Not Assigned</option>
            <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
            <option value="in_progress" {{ $task->status=='in_progress'?'selected':'' }}>In Progress</option>
            <option value="complete" {{ $task->status=='complete'?'selected':'' }}>Complete</option>
        </select>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary no-loading">
            Back
        </a>

        <button class="btn btn-primary">
            Update Task
        </button>
    </div>
</form>

@endsection