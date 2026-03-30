<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query()->with(['assignedTo', 'assignedBy', 'createdBy']);

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('priority', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('due_date', 'like', "%{$search}%")

                ->orWhereHas('assignedTo', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('assignedBy', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('createdBy', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        if (in_array($sort, ['title', 'priority', 'status', 'due_date'])) {
            $query->orderBy($sort, $direction);
        }

        if ($sort === 'assignedTo') {
            $query->leftJoin('users as u1', 'tasks.assigned_to', '=', 'u1.id')
                ->orderBy('u1.name', $direction)
                ->select('tasks.*');
        }

        $tasks = $query->paginate(5)->withQueryString();

        $staff = User::where('role','staff')->get();

        return view('tasks.index', compact('tasks','staff'));
    }

    public function show(Task $task)
    {
        if (auth()->user()->role === 'staff') {
            if ($task->assigned_to != auth()->id()) {
                abort(403, 'You are not authorized to view this task.');
            }
        }
        // Admin can view all tasks

        return view('tasks.show', compact('task'));
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
            'status' => 'required|in:not_assigned,pending,in_progress,complete', //same as rule::in
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

    public function myTasks(Request $request)
    {
        $query = Task::where('assigned_to', Auth::user()->id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('priority', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        if (in_array($sort, ['title', 'priority', 'status', 'id'])) {
            $query->orderBy($sort, $direction);
        }

        $tasks = $query->paginate(5)->withQueryString();

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
