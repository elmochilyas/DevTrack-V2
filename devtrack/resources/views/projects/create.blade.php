<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    
    <input type="text" name="title" placeholder="Project Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="datetime-local" name="deadline" required>
    
    <button type="submit">Create Project</button>
</form>
