<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
}
