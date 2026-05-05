<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'title',
        'description',
        'deadline',
        'created_by',
    ];

    
     protected $casts = [
        'deadline' => 'datetime',
    ];

    //Get the user who created this project
     public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    //Get all team members of this project
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    //Get all tasks in this project
     public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
