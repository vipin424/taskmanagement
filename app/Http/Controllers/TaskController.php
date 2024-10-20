<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::query();

                // If 'status' is selected, filter based on the status
            if ($request->filled('status')) {
                $tasks->where('status', $request->input('status'));
            } else {
                // Exclude "Deleted" tasks unless the user is specifically filtering for them
                $tasks->where('status', '!=', 'Deleted');
            }

            // If the search query is provided, filter by title or description
            if ($request->filled('search')) {
                $tasks->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('description', 'like', '%' . $request->input('search') . '%');
                });
            }

        $tasks = $tasks->orderBy('due_date', 'desc')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date|after:now',
        ]);

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'status' => 'Pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if ($task->status === 'Completed') {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot edit a completed task.'
            ], 403); // Forbidden status code
        }
    
        // Return the view for editing if not completed
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'in:Pending,Completed,Deleted',
        ]);
    
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->status === 'Pending') {
            // Return an error response for SweetAlert if the task is "Pending"
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot delete a pending task.'
            ], 403); // Forbidden status code
        }
    
        // Proceed to delete if the task is "Completed"
        if ($task->status === 'Completed') {
            $task->update(['status' => 'Deleted']);
            return response()->json([
                'status' => 'success',
                'message' => 'Task has been deleted.'
            ]);
        }
    
        // If for some reason status doesn't match, return a generic error
        return response()->json([
            'status' => 'error',
            'message' => 'An unexpected error occurred.'
        ], 400);
    

    }
}
