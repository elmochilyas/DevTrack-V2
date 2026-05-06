<h1>{{ $project->title }}</h1>
<p>{{ $project->description }}</p>
<p>Deadline: {{ $project->deadline->format('Y-m-d') }}</p>

<h2>Team Members</h2>
<ul>
    @foreach ($project->members as $member)
        <li>{{ $member->name }} ({{ $member->pivot->role }})</li>
    @endforeach
</ul>

<h2>Tasks</h2>
@foreach ($project->tasks as $task)
    <div>{{ $task->title }} - {{ $task->status }}</div>
@endforeach
