<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskStatusNotification;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Teacher']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['teacher', 'student'])->where('teacher_id', auth()->user()->id)->get();

        return view('admin.task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role', 'Student')->where('created_by', auth()->user()->id)->pluck('name', 'id');

        return view('admin.task.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::findOrFail($request->student_id);

        if ($student->created_by !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => auth()->user()->id,
            'student_id' => $student->id,
        ]);

        $task->student->notify(new TaskStatusNotification($task, 'created'));
        $task->teacher->notify(new TaskStatusNotification($task, 'created'));

        return redirect()->route('tasks.index')->with('success', 'Task assigned.');
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
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $students = User::where('role', 'Student')->where('created_by', auth()->user()->id)->pluck('name', 'id');
        $selectedStudent = $task->student->id;

        return view('admin.task.edit', compact('task', 'students', 'selectedStudent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'student_id' => 'required|exists:users,id',
        ]);

        $task = Task::findOrFail($id);

        $student = User::findOrFail($request->student_id);

        if ($student->created_by !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'student_id' => $student->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task assigned update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        if ($task->teacher_id !== auth()->user()->id) {
            abort(403);
        }

        $task->delete();

        return back()->with('message', 'Task deleted.');
    }
}
