<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Student']);
    }

    public function create($id)
    {
        $task = Task::findOrFail($id);

        return view('admin.student.taskSubmission.submission', compact('task'));
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        if (!$task->approved_at || $task->student_id !== auth()->user()->id) {
            abort(403);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('task_submissions', 'public');
        }

        TaskSubmission::create([
            'task_id' => $task->id,
            'student_id' => auth()->user()->id,
            'notes' => $request->notes,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Task submitted!');
    }
}
