@foreach ($projects as $project)
    <div class="project-card">
        <h3>{{ $project->title }}</h3>
        <p>Deadline: {{ $project->deadline->format('Y-m-d') }}</p>
        <p>Tasks: {{ $project->tasks->count() }} total,
           {{ $project->tasks->where('status', 'done')->count() }} done</p>

        @can('edit', $project)
            <a href="{{ route('projects.edit', $project) }}">Edit</a>
        @endcan
    </div>
@endforeach
