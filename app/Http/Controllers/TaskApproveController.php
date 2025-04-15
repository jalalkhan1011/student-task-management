<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Notifications\TaskStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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

        Notification::send([$task->teacher, $task->student], new TaskStatusNotification($task, 'approved'));

        return back()->with('message', 'Task approved.');
    }
}
