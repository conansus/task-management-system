@extends('layouts.app')

@section('content')

<h3>Create Task</h3>

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <input name="title" class="form-control mb-2" placeholder="Title">

    <textarea name="description" class="form-control mb-2"></textarea>

    <select name="priority" class="form-control mb-2">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>

    <input type="date" name="due_date" class="form-control mb-2">

    <select name="assigned_to" class="form-control mb-2">
        <option value="">-- Assign Staff --</option>
        @foreach($staff as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>

    <button class="btn btn-success">Create</button>
</form>

@endsection