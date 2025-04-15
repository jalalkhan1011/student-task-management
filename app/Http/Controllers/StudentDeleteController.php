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
        $student->update(['status' => 'approved']);
        $student->delete(); // soft delete
        $status = DeletionRequest::where('student_id', $id)->first();

        $status->update(['status' => 'approved']);

        return back()->with('message', 'Student deleted.');
    }

    public function studentDeleteReject($id)
    {
        $student = User::findOrFail($id);
        $student->update(['status' => 'rejected']);

        $status = DeletionRequest::where('student_id', $id)->first();
        $status->update(['status' => 'rejected']);

        return back()->with('message', 'Student deletion request rejected.');
    }
}
