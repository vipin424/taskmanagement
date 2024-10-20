<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Management App')</title>
    <!-- Include Bootstrap or Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <!-- Include custom CSS if needed -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="container">
    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light mb-3">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">Task Management</a>
        <form class="form-inline" action="{{ route('tasks.index') }}" method="GET">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search tasks..." value="{{ request('search') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
</div>

<!-- Include Bootstrap JS or your custom scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
