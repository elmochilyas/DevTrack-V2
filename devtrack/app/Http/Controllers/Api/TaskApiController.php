<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
   use AuthorizesRequests;
    
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks()
            ->with('assignee')
            ->orderBy('deadline')
            ->get();

        return TaskResource::collection($tasks);
    }

    
    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $task);

        $task->load('assignee');

        return new TaskResource($task);
    }
}

