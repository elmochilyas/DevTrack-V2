<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('projects.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                        {{ $project->title }}
                    </h2>
                    <div class="flex items-center gap-2 mt-1">
                        @if($project->deadline->isPast() && $project->tasks->where('status', '!=', 'done')->count() > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.098c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.332-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.648-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Overdue
                            </span>
                        @endif
                        <span class="text-sm text-gray-500">{{ $project->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-200 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 hover:border-indigo-200 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.9a2 2 0 111.414 1.414L11.586 18H9v-2.586l8.586-8.586z"></path>
                        </svg>
                        {{ __('Edit Project') }}
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-r-lg shadow-sm" role="alert">
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
                    <!-- Project Details Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Project Details</h3>
                        </div>
                        <div class="p-6">
                            @if($project->description)
                                <div class="mb-6">
                                    <p class="text-gray-700 leading-relaxed">{{ $project->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Deadline</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $project->deadline->format('M d, Y \a\t H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Tasks</p>
                                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $project->tasks->count() }} tasks</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            @php
                                $totalTasks = $project->tasks->count();
                                $doneTasks = $project->tasks->where('status', 'done')->count();
                                $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                            @endphp
                            @if($totalTasks > 0)
                                <div class="mt-8 pt-6 border-t border-gray-100">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-sm font-semibold text-gray-700">Project Progress</span>
                                        <span class="text-2xl font-bold text-indigo-600">{{ $progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-1000 ease-out shadow-lg shadow-indigo-500/20" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 mt-3">
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                            {{ $doneTasks }} completed
                                        </span>
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-1.5"></span>
                                            {{ $project->tasks->where('status', 'todo')->count() }} to do
                                        </span>
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></span>
                                            {{ $project->tasks->where('status', 'in_progress')->count() }} in progress
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tasks Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-bold text-gray-900">Tasks</h3>
                                @can('create', [App\Models\Task::class, $project])
                                    <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-xs text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Task
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="p-6">
                            @if($project->tasks->count() > 0)
                                <div class="space-y-3">
                                    @foreach($project->tasks->sortBy('deadline') as $task)
                                        <div class="group border-2 border-gray-100 rounded-xl p-5 hover:bg-indigo-50/50 hover:border-indigo-200 transition-all duration-200">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                        @if($task->status === 'done')
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Done
                                                            </span>
                                                        @elseif($task->status === 'in_progress')
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                                <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                                    <circle cx="10" cy="10" r="5"></circle>
                                                                </svg>
                                                                In Progress
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                To Do
                                                            </span>
                                                        @endif

                                                        @if($task->priority === 'high')
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                                High
                                                            </span>
                                                        @elseif($task->priority === 'medium')
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                                Medium
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                                Low
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                        {{ $task->title }}
                                                    </a>
                                                    @if($task->description)
                                                        <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $task->description }}</p>
                                                    @endif
                                                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                                                        @if($task->assignee)
                                                            <span class="inline-flex items-center">
                                                                <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                                {{ $task->assignee->name }}
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center text-gray-400">
                                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                                Unassigned
                                                            </span>
                                                        @endif
                                                        <span class="inline-flex items-center">
                                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $task->deadline->format('M d') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col gap-2 ml-4">
                                                    @can('updateStatus', $task)
                                                        <form action="{{ route('tasks.updateStatus', [$project, $task]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <select onchange="this.form.submit()" name="status" class="text-xs border-2 border-gray-200 rounded-lg px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500 bg-white hover:bg-gray-50 transition-colors cursor-pointer">
                                                                <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>To Do</option>
                                                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                                            </select>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 mb-6">No tasks yet. Create the first task!</p>
                                    @can('create', [App\Models\Task::class, $project])
                                        <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 transform hover:scale-105">
                                            + Create First Task
                                        </a>
                                    @endcan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Team Members -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900">Team Members</h3>
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">{{ $project->members->count() }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($project->members as $member)
                                    <div class="flex items-center justify-between rounded-xl p-2 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center space-x-3 min-w-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                                                <span class="text-sm font-bold text-white">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $member->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $member->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 ml-2 flex-shrink-0">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $member->pivot->role === 'lead' ? 'bg-gradient-to-r from-indigo-500 to-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($member->pivot->role) }}
                                            </span>
                                            @can('update', $project)
                                                @if($member->pivot->role !== 'lead')
                                                    <form action="{{ route('projects.members.remove', [$project, $member]) }}" method="POST"
                                                          onsubmit="return confirm('Remove {{ $member->name }} from this project?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-6 h-6 flex items-center justify-center rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @can('update', $project)
                                <div class="mt-5 pt-5 border-t border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Add Member</p>
                                    @if($errors->has('email'))
                                        <p class="text-xs text-red-600 mb-2">{{ $errors->first('email') }}</p>
                                    @endif
                                    <form action="{{ route('projects.members.add', $project) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="email" name="email" placeholder="developer@email.com"
                                               class="flex-1 text-sm rounded-xl border-2 border-gray-200 px-3 py-2.5 focus:border-indigo-500 focus:ring-indigo-500 transition-colors placeholder-gray-400">
                                        <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors">
                                            Add
                                        </button>
                                    </form>
                                    <p class="text-xs text-gray-400 mt-2">Invite a developer by email address</p>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Statistics</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Total Tasks</span>
                                    <span class="text-xl font-bold text-gray-900">{{ $project->tasks->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                    <span class="text-sm font-medium text-green-600 inline-flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Completed
                                    </span>
                                    <span class="text-xl font-bold text-green-600">{{ $project->tasks->where('status', 'done')->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                                    <span class="text-sm font-medium text-yellow-600 inline-flex items-center">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                        In Progress
                                    </span>
                                    <span class="text-xl font-bold text-yellow-600">{{ $project->tasks->where('status', 'in_progress')->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600 inline-flex items-center">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                        To Do
                                    </span>
                                    <span class="text-xl font-bold text-gray-600">{{ $project->tasks->where('status', 'todo')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
