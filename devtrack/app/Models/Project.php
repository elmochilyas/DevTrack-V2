<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    // Mutator: store title as ucfirst automatically
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucfirst($value),
        );
    }

    // Accessor: deadline status for views and API
    protected function deadlineStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->deadline->isPast()) {
                    return 'overdue';
                }
                if ($this->deadline->diffInHours(now()) < 48) {
                    return 'urgent';
                }
                if ($this->deadline->diffInDays(now()) < 7) {
                    return 'soon';
                }
                return 'ok';
            },
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
