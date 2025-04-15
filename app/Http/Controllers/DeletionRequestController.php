<?php

namespace App\Http\Controllers;

use App\Models\DeletionRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DeletionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Teacher']);
    }

    public function deleteRequest(User $student)
    {
        if ($student->created_by != auth()->user()->id) {
            abort(403);
        }

        DeletionRequest::create([
            'student_id' => $student->id,
            'requested_by' => auth()->user()->id,
        ]);
        $student->update([
            'status' => 'pending'
        ]);

        return back()->with('message', 'Deletion request submitted.');
    }
}
