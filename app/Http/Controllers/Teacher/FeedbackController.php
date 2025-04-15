<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Teacher']);
    }

    public function create($id)
    {
        $task = Task::findOrFail($id);

        return view('admin.task.feedback.feedback', compact('task'));
    }

    public function store(Request $request, TaskSubmission $submission)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);

        if ($submission->task->teacher_id !== auth()->user()->id) {
            abort(403);
        }

        $submission->update(['feedback' => $request->feedback]);

        return redirect(route('tasks.index'))->with('success', 'Feedback submitted!');
    }
}
