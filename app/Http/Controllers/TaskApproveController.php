<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskApproveController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Headmaster']);
    }

    public function index()
    {
        $pendingTasks = Task::with(['Teacher', 'Student'])->withTrashed()->get();

        return view('admin.headmaster.task.index', compact('pendingTasks'));
    }

    public function taskApprove($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['approved_at' => now()]);

        return back()->with('message', 'Task approved.');
    }
}
