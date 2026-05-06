<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all projects where user is a member (lead or developer)
        $projects = auth()->user()
            ->projects()  // From User model relationship
            ->with('tasks', 'members')  // Eager load to avoid N+1
            ->get();

        // Also add projects where user is the LEAD
        $ledProjects = Project::where('created_by', auth()->id())
            ->with('tasks', 'members')
            ->get();

        // Merge and remove duplicates (if user is both lead and member)
        $projects = $projects->merge($ledProjects)->unique('id');

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Any user can create, so no authorization needed
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // Authorization: user already proved they can create (by reaching this method)
        // But let's be explicit
        $this->authorize('create', Project::class);

        // Create project with current user as creator
        $project = Project::create([
            'title' => $request->validated()['title'],
            'description' => $request->validated()['description'],
            'deadline' => $request->validated()['deadline'],
            'created_by' => auth()->id(),
        ]);

        // Add user to project as LEAD
        $project->members()->attach(auth()->id(), ['role' => 'lead']);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // Check authorization using Policy
        $this->authorize('view', $project);

        // Load relationships
        $project->load('tasks', 'members');

        return view('projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project updated');
    }
}
