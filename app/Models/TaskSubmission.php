<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = ['task_id', 'student_id', 'notes', 'file_path', 'feedback'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
