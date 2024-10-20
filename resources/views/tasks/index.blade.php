@extends('layouts.app')

@section('title', 'Task List')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
</div>

<!-- Filter Options -->
<form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select class="form-select" name="status" onchange="this.form.submit()">
                <option value="">Filter by Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Deleted" {{ request('status') == 'Deleted' ? 'selected' : '' }}>Deleted</option>
            </select>
        </div>
    </div>
</form>

<!-- Task Accordion -->
<div class="accordion" id="taskAccordion">
    @foreach($tasks as $task)
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading{{ $task->id }}">
            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $task->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                {{ $task->title }} <span class="badge bg-info ms-3">{{ $task->status }}</span>
            </button>
        </h2>
        <div id="collapse{{ $task->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $task->id }}" data-bs-parent="#taskAccordion">
            <div class="accordion-body">
                <p><strong>Description:</strong> {{ $task->description }}</p>
                <p><strong>Due Date:</strong> {{ $task->due_date->format('d M Y, H:i') }}</p>
                <p><strong>Time Lapsed:</strong> {{ $task->created_at->diffForHumans() }}</p>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning me-2 btn-edit" data-task-id="{{ $task->id }}">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete"
                    data-task-id="{{ $task->id }}"
                    data-task-title="{{ $task->title }}"
                    data-is-editing="false">Delete</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $tasks->links('pagination::bootstrap-4') }}
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(function (deleteButton) {
            deleteButton.addEventListener('click', function (event) {
                const taskId = this.getAttribute('data-task-id');
                const taskTitle = this.getAttribute('data-task-title');

                // Show confirmation dialog before proceeding with deletion
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete the task: "${taskTitle}". This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/tasks/${taskId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'error') {
                                // Show SweetAlert warning for pending tasks
                                Swal.fire({
                                    title: 'Warning',
                                    text: data.message,
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            } else if (data.status === 'success') {
                                // Show SweetAlert for successful deletion and reload the page
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); // Reload the page to update the task list
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        // Set up Edit Mode
        document.querySelectorAll('.btn-edit').forEach(function (editButton) {
            editButton.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default behavior

                const taskId = this.getAttribute('data-task-id');

                // Check the task status by making an AJAX request to the server
                fetch(`/tasks/${taskId}/edit`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        // Show SweetAlert error message if the task is completed
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Redirect to the edit page if not completed
                        window.location.href = `/tasks/${taskId}/edit`;
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endsection




