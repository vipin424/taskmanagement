<!-- resources/views/tasks/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<h1>Edit Task</h1>

<!-- Task Edit Form -->
<form method="POST" action="{{ route('tasks.update', $task) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $task->title) }}" required>
        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $task->description) }}</textarea>
        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Task Status</label>
        <select name="status" class="form-select" required>
            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>
        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>
@endsection
