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
            <span class="text-gray-900 truncate max-w-32">{{ $project->title }}</span>
        </nav>
    @endsection

    <x-slot name="navActions">
        <a href="{{ route('projects.tasks.index', $project) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            View Tasks
        </a>
        @can('update', $project)
            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-indigo-300 hover:text-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.9a2 2 0 111.414 1.414L11.586 18H9v-2.586l8.586-8.586z"></path>
                </svg>
                Edit Project
            </a>
        @endcan
    </x-slot>

    @php
        $totalTasks = $project->tasks->count();
        $doneTasks = $project->tasks->where('status', 'done')->count();
        $inProgressTasks = $project->tasks->where('status', 'in_progress')->count();
        $todoTasks = $project->tasks->where('status', 'todo')->count();
        $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
    @endphp

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

            <!-- Project Header -->
            <div class="mb-8 animate-fade-in">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $project->title }}</h1>
                        @if($project->description)
                            <p class="mt-2 text-gray-600 max-w-3xl leading-relaxed">{{ $project->description }}</p>
                        @endif
                    </div>
                    <!-- Deadline Badge -->
                    @php
                        $deadlineColors = [
                            'overdue' => 'bg-red-100 text-red-800 border-red-200',
                            'urgent'  => 'bg-orange-100 text-orange-800 border-orange-200',
                            'soon'    => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'ok'      => 'bg-green-100 text-green-800 border-green-200',
                        ];
                    @endphp
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border {{ $deadlineColors[$project->deadline_status] }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $project->deadline->format('M d, Y \a\t H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Tasks -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Tasks Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 100ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-gray-900">Tasks</h3>
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">{{ $totalTasks }}</span>
                                </div>
                                @can('create', [App\Models\Task::class, $project])
                                    <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-xs text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Task
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="p-6">
                            @if($totalTasks > 0)
                                <!-- Task Filters -->
                                <div class="flex gap-2 mb-6 flex-wrap">
                                    <button onclick="filterTasks('all')" class="task-filter-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 bg-indigo-100 text-indigo-700" data-filter="all">
                                        All <span class="ml-1 text-xs opacity-75">{{ $totalTasks }}</span>
                                    </button>
                                    <button onclick="filterTasks('todo')" class="task-filter-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-600 hover:bg-gray-100" data-filter="todo">
                                        To Do <span class="ml-1 text-xs opacity-75">{{ $todoTasks }}</span>
                                    </button>
                                    <button onclick="filterTasks('in_progress')" class="task-filter-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-600 hover:bg-gray-100" data-filter="in_progress">
                                        In Progress <span class="ml-1 text-xs opacity-75">{{ $inProgressTasks }}</span>
                                    </button>
                                    <button onclick="filterTasks('done')" class="task-filter-btn px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-600 hover:bg-gray-100" data-filter="done">
                                        Done <span class="ml-1 text-xs opacity-75">{{ $doneTasks }}</span>
                                    </button>
                                </div>

                                <div class="space-y-3" id="tasks-list">
                                    @foreach($project->tasks->sortBy('deadline') as $task)
                                        <div class="task-item group border-2 border-gray-100 rounded-xl p-5 hover:bg-indigo-50/30 hover:border-indigo-200 hover:shadow-sm transition-all duration-200" data-status="{{ $task->status }}">
                                            <div class="flex justify-between items-start gap-4">
                                                <div class="flex-1 min-w-0">
                                                    <!-- Status & Priority Badges -->
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
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"></path>
                                                                </svg>
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

                                                    <!-- Task Title & Description -->
                                                    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="block">
                                                        <h4 class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $task->title }}</h4>
                                                        @if($task->description)
                                                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $task->description }}</p>
                                                        @endif
                                                    </a>

                                                    <!-- Task Meta -->
                                                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-500 flex-wrap">
                                                        @if($task->assignee)
                                                            <span class="inline-flex items-center gap-1.5">
                                                                <div class="w-5 h-5 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-md flex items-center justify-center">
                                                                    <span class="text-xs font-bold text-white">{{ strtoupper(substr($task->assignee->name, 0, 1)) }}</span>
                                                                </div>
                                                                {{ $task->assignee->name }}
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center text-gray-400">
                                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                                Unassigned
                                                            </span>
                                                        @endif
                                                        <span class="inline-flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $task->deadline->format('M d, Y') }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Status Update -->
                                                <div class="flex-shrink-0">
                                                    @can('updateStatus', $task)
                                                        <form action="{{ route('tasks.updateStatus', [$project, $task]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <select onchange="this.form.submit()" name="status" class="text-xs border-2 border-gray-200 rounded-lg px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 bg-white hover:bg-gray-50 transition-colors cursor-pointer">
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
                                        <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 hover:-translate-y-0.5 transition-all duration-200">
                                            + Create First Task
                                        </a>
                                    @endcan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar -->
                <div class="space-y-6">
                    <!-- Team Members -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 150ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900">Team Members</h3>
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">{{ $project->members->count() }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($project->members as $member)
                                    <div class="flex items-center justify-between rounded-xl p-3 hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3 min-w-0">
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
                                                        <button type="submit" class="w-6 h-6 flex items-center justify-center rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100" aria-label="Remove member">
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
                                        <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all duration-200">
                                            Add
                                        </button>
                                    </form>
                                    <p class="text-xs text-gray-400 mt-2">Invite a developer by email address</p>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <!-- Project Progress -->
                    @if($totalTasks > 0)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 200ms">
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900">Project Progress</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $doneTasks }} of {{ $totalTasks }} tasks completed</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-3xl font-extrabold text-indigo-600">{{ $progress }}%</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden mb-4">
                                    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600 h-4 rounded-full transition-all duration-1000 ease-out shadow-lg shadow-indigo-500/20" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-gray-400 rounded-full flex-shrink-0"></span>
                                        <div>
                                            <p class="text-xs text-gray-500">To Do</p>
                                            <p class="text-lg font-bold text-gray-700">{{ $todoTasks }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-yellow-500 rounded-full flex-shrink-0"></span>
                                        <div>
                                            <p class="text-xs text-gray-500">In Progress</p>
                                            <p class="text-lg font-bold text-yellow-600">{{ $inProgressTasks }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-green-500 rounded-full flex-shrink-0"></span>
                                        <div>
                                            <p class="text-xs text-gray-500">Done</p>
                                            <p class="text-lg font-bold text-green-600">{{ $doneTasks }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-slide-up" style="animation-delay: 200ms">
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900">Project Progress</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600">No tasks yet. Start by creating your first task!</p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function filterTasks(status) {
            const tasks = document.querySelectorAll('.task-item');
            const buttons = document.querySelectorAll('.task-filter-btn');

            // Update active button
            buttons.forEach(btn => {
                if (btn.dataset.filter === status) {
                    btn.classList.add('active', 'bg-indigo-100', 'text-indigo-700');
                    btn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                } else {
                    btn.classList.remove('active', 'bg-indigo-100', 'text-indigo-700');
                    btn.classList.add('text-gray-600', 'hover:bg-gray-100');
                }
            });

            // Filter tasks
            tasks.forEach(task => {
                if (status === 'all' || task.dataset.status === status) {
                    task.style.display = 'block';
                } else {
                    task.style.display = 'none';
                }
            });
        }

        // Initialize filter buttons
        document.addEventListener('DOMContentLoaded', () => {
            const activeBtn = document.querySelector('.task-filter-btn.active');
            if (activeBtn) {
                activeBtn.classList.add('bg-indigo-100', 'text-indigo-700');
            }
        });
    </script>
    @endpush
</x-app-layout>
