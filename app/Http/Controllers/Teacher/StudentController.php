<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DeletionRequest;
use App\Models\User;
use App\Notifications\StudentCreatedNotification;
use App\Notifications\StudentWelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Headmaster|Teacher']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deletions = DeletionRequest::all();

        if (auth()->user()->role == 'Teacher') {
            $students = User::where('role', 'student')->where('created_by', auth()->user()->id)->withTrashed()->get();
        } else {
            $students = User::where('role', 'student')->withTrashed()->get();
        }


        return view('admin.student.index', compact('students', 'deletions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Student',
            'created_by' => auth()->user()->id,
        ];

        $student = User::create($data);

        //Headmaster Notify
        $headmasters = User::where('role', 'Headmaster')->get();
        Notification::send($headmasters, new StudentCreatedNotification($student));

        //Student Welcome 
        $student->notify(new StudentWelcomeNotification());

        return redirect(route('students.index'))->with('success', 'Student created successfully!');
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
        $student = User::findOrFail($id);

        return view('admin.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'password' => 'same:password_confirmation',
        ]);

        $data = $request->all();
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = Arr::except($data, array('password'));
        }
        $student->update($data);

        return redirect(route('students.index'))->with('success', 'Student Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::findOrFail($id);
    }
}
