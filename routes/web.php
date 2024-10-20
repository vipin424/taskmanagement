<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Resource route for tasks (automatically generates all necessary routes)
Route::resource('tasks', TaskController::class);

// You can also define the homepage to redirect to the tasks index:
Route::get('/', function () {
    return redirect()->route('tasks.index');
});
