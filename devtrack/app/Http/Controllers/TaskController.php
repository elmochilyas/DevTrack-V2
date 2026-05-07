<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorize('viewAny', [Task::class, $project]);

        // Load tasks with eager loading to prevent N+1 queries
        $tasks = $project->tasks()
            ->with('assignee', 'project')
            ->orderBy('deadline')
            ->get();

        return view('tasks.index', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $this->authorize('create', [Task::class, $project]);

        $members = $project->members()->get();

        return view('tasks.create', compact('project', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $this->authorize('create', [Task::class, $project]);

        $project->tasks()->create(array_merge(
            $request->validated(),
            ['status' => 'todo']
        ));

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $task);

        $task->load('assignee', 'project');

        return view('tasks.show', compact('project', 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        $this->authorize('update', $task);

        $members = $project->members()->get();

        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return redirect()
            ->route('projects.tasks.show', [$project, $task])
            ->with('success', 'Task updated');
    }

    public function updateStatus(Request $request, Project $project, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $validated['status']]);

        return redirect()
            ->back()
            ->with('success', 'Task status updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Task deleted');
    }
}
