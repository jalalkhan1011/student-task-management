<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class StudentTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Student']);
    }

    public function index()
    {
        $tasks = Task::with('teacher')->where('student_id', auth()->user()->id)->whereNotNull('approved_at')->get();

        return view('admin.student.task.index',compact('tasks'));
    }
}
