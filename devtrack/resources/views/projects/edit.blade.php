<form action="{{ route('projects.update', $project) }}" method="POST">
    @csrf
    @method('PUT')
    
    <input type="text" name="title" value="{{ $project->title }}" required>
    <textarea name="description">{{ $project->description }}</textarea>
    <input type="datetime-local" name="deadline" value="{{ $project->deadline }}" required>
    
    <button type="submit">Update Project</button>
</form>
