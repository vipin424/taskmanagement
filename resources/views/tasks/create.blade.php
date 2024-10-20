<!-- resources/views/tasks/create.blade.php -->
@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
<h1>Create New Task</h1>

<!-- Task Creation Form -->
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description') }}</textarea>
        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="datetime-local" name="due_date" class="form-control" id="due_date" value="{{ old('due_date') }}" required>
        @error('due_date') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save Task</button>
</form>
@endsection
