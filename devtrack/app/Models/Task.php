<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'deadline',
        'status',
        'priority',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];


    //Get the project this task belongs to
     public function project()
    {
        return $this->belongsTo(Project::class);
    }


    //Get the user assigned to this task
     public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
