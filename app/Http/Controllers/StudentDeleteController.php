<?php

namespace App\Http\Controllers;

use App\Models\DeletionRequest;
use App\Models\User;
use Illuminate\Http\Request;

class StudentDeleteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Headmaster']);
    }

    public function deleteStudent($id)
    {
        $student = User::findOrFail($id);
        $student->delete(); // soft delete
        $status = DeletionRequest::where('student_id', $id)->first();

        $status->update(['status' => 'approved']);

        return back()->with('message', 'Student deleted.');
    }
}
