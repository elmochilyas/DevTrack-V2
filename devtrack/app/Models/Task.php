<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status) {
                'todo'        => 'To Do',
                'in_progress' => 'In Progress',
                'done'        => 'Done',
                default       => ucfirst($this->status),
            }
        );
    }

    protected function deadlineStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->status === 'done') return 'done';

                $hoursLeft = now()->diffInHours($this->deadline, false);

                return match (true) {
                    $hoursLeft < 0   => 'overdue',
                    $hoursLeft < 48  => 'urgent',
                    $hoursLeft < 168 => 'soon',
                    default          => 'ok',
                };
            }
        );
    }

    protected function priorityLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->priority) {
                'low'    => 'Low',
                'medium' => 'Medium',
                'high'   => 'High',
                default  => ucfirst($this->priority),
            }
        );
    }


    public function scopeUrgent(Builder $query): Builder
    {
        return $query
            ->where('status', '!=', 'done')
            ->where('deadline', '<=', now()->addHours(48));
    }

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
