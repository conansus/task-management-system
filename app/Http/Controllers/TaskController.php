<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $staff = User::where('role','staff')->get();
        return view('tasks.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high', //must be one of those values
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id', //if exist, must match one of id in users table
        ]);

        $data['created_by'] = Auth::user()->id;
        if (!empty($data['assigned_to'])) {
            $data['assigned_by'] = Auth::user()->id;
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'not_assigned';
        }
        Task::create($data);

        return redirect()->action([TaskController::class,'index'])->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task) //Task will do findorfail, frontend can pass array or single value
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:not_assigned,pending,in_progress,complete',
        ]);

        if (!empty($data['assigned_to']) && $task->assigned_to != $data['assigned_to']) {
            $data['assigned_by'] = Auth::user()->id;
            if ($task->status === 'not_assigned') {
                $data['status'] = 'pending';
            }
        } elseif (empty($data['assigned_to'])) {
            $data['assigned_by'] = null;
            $data['assigned_to'] = null;
            $data['status'] = 'not_assigned';
        }

        $task->update($data);
        return redirect('/tasks')->with('success','Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete(); //hard delete
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function assign(Request $request, Task $task)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $task->assigned_to = $data['user_id'];
        $task->assigned_by = Auth::user()->id;
        $task->status = 'pending';
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task assigned successfully.');
    }

    public function myTasks()
    {
        $tasks = Task::where('assigned_to', Auth::user()->id)->orderBy('id','desc')->get();
        return view('tasks.my', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,in_progress,complete',
        ]);

        $task->status = $data['status'];
        $task->save();

        return redirect()->route('tasks.my')->with('success', 'Task status updated.');
    }

}
