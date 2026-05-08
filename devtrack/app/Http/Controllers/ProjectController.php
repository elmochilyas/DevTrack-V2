<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
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
            'description' => $request->validated()['description'] ?? null,
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project archived');
    }

    public function archived()
    {
        $projects = Project::onlyTrashed()
            ->where('created_by', auth()->id())
            ->with('tasks', 'members')
            ->get();

        return view('projects.archived', ['projects' => $projects]);
    }

    public function restore(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return redirect()
            ->route('projects.archived')
            ->with('success', 'Project restored');
    }

    public function forceDelete(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $project);

        $project->forceDelete();

        return redirect()
            ->route('projects.archived')
            ->with('success', 'Project permanently deleted');
    }

    public function showMembers(Project $project)
    {
        $this->authorize('update', $project);

        $members = $project->members()->get();

        return view('projects.members', [
            'project' => $project,
            'members' => $members,
        ]);
    }

    public function addMember(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($project->members()->where('user_id', $user->id)->exists() || $project->created_by === $user->id) {
            return back()->withErrors(['email' => 'User is already a member of this project.']);
        }

        $project->members()->attach($user->id, ['role' => 'developer']);

        return back()->with('success', 'Member added successfully');
    }

    public function removeMember(Request $request, Project $project, User $user)
    {
        $this->authorize('update', $project);

        if ($project->created_by === $user->id) {
            return back()->withErrors(['member' => 'Cannot remove the project lead.']);
        }

        $project->members()->detach($user->id);

        return back()->with('success', 'Member removed');
    }
}
