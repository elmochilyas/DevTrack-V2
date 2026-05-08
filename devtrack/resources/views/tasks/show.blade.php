<x-app-layout>
    @section('breadcrumbs')
        <nav class="flex items-center text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">Projects</a>
            <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('projects.show', $project) }}" class="text-gray-400 hover:text-gray-600 transition-colors truncate max-w-32">{{ $project->title }}</a>
            <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 truncate max-w-32">{{ $task->title }}</span>
        </nav>
    @endsection

    <x-slot name="navActions">
        @can('update', $task)
            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-indigo-300 hover:text-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.9a2 2 0 111.414 1.414L11.586 18H9v-2.586l8.586-8.586z"></path>
                </svg>
                Edit Task
            </a>
        @endcan
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-r-2xl shadow-sm animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Task Details -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 100ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Task Details</h3>
                        </div>
                        <div class="p-6">
                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                @if($task->priority === 'high')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        High Priority
                                    </span>
                                @elseif($task->priority === 'medium')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">Medium Priority</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">Low Priority</span>
                                @endif

                                @if($task->deadline->isPast() && $task->status !== 'done')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-50 text-red-700 border border-red-200">Overdue</span>
                                @elseif(!$task->deadline->isPast() && $task->deadline->diffInHours(now()) <= 48 && $task->status !== 'done')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-amber-50 text-amber-700 border border-amber-200">Due Soon</span>
                                @endif
                            </div>

                            @if($task->description)
                                <div class="mb-6">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Description</p>
                                    <p class="text-gray-700 leading-relaxed">{{ $task->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Deadline</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $task->deadline->format('M d, Y \a\t H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Assigned To</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">
                                            {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status (developer view) -->
                    @can('updateStatus', $task)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 150ms">
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900">Update Status</h3>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('tasks.updateStatus', [$project, $task]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-3 gap-3 mb-6">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="status" value="todo" {{ $task->status === 'todo' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="border-2 rounded-xl p-4 text-center transition-all duration-200 peer-checked:border-gray-500 peer-checked:bg-gray-50 hover:border-gray-300">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full block mx-auto mb-2"></span>
                                                <span class="text-sm font-semibold text-gray-700">To Do</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="status" value="in_progress" {{ $task->status === 'in_progress' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="border-2 rounded-xl p-4 text-center transition-all duration-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:border-yellow-300">
                                                <span class="w-2 h-2 bg-yellow-400 rounded-full block mx-auto mb-2 animate-pulse"></span>
                                                <span class="text-sm font-semibold text-yellow-700">In Progress</span>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="status" value="done" {{ $task->status === 'done' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="border-2 rounded-xl p-4 text-center transition-all duration-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300">
                                                <span class="w-2 h-2 bg-emerald-400 rounded-full block mx-auto mb-2"></span>
                                                <span class="text-sm font-semibold text-emerald-700">Done</span>
                                            </div>
                                        </label>
                                    </div>
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 hover:shadow-indigo-500/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Save Status
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Task Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 200ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Info</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Status</span>
                                @if($task->status === 'done')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Done
                                    </span>
                                @elseif($task->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                                        In Progress
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                        To Do
                                    </span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Priority</span>
                                @if($task->priority === 'high')
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-red-600">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        High
                                    </span>
                                @elseif($task->priority === 'medium')
                                    <span class="text-sm font-semibold text-orange-600">Medium</span>
                                @else
                                    <span class="text-sm font-semibold text-blue-600">Low</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Project</span>
                                <a href="{{ route('projects.show', $project) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors max-w-32 text-right truncate">{{ $project->title }}</a>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Created</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $task->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Updated</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $task->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    @can('delete', $task)
                        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden animate-slide-up" style="animation-delay: 250ms">
                            <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                                <h3 class="text-base font-bold text-red-800">Danger Zone</h3>
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-gray-500 mb-4">Permanently delete this task. This action cannot be undone.</p>
                                <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" onsubmit="return confirm('Delete this task permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Task
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
