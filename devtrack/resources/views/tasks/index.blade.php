<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('projects.show', $project) }}"
                   class="w-9 h-9 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-extrabold text-gray-900 leading-tight">Tasks</h2>
                    <p class="text-sm text-gray-500">{{ $project->title }}</p>
                </div>
            </div>
            @can('create', [App\Models\Task::class, $project])
                <a href="{{ route('projects.tasks.create', $project) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Task
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if($tasks->count() > 0)
                @php
                    $total      = $tasks->count();
                    $done       = $tasks->where('status', 'done')->count();
                    $inProgress = $tasks->where('status', 'in_progress')->count();
                    $todo       = $tasks->where('status', 'todo')->count();
                @endphp

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total</p>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $total }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">To Do</p>
                        <p class="text-3xl font-extrabold text-gray-600">{{ $todo }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-yellow-200 px-5 py-4">
                        <p class="text-xs font-semibold text-yellow-500 uppercase tracking-wider mb-1">In Progress</p>
                        <p class="text-3xl font-extrabold text-yellow-600">{{ $inProgress }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-emerald-200 px-5 py-4">
                        <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wider mb-1">Done</p>
                        <p class="text-3xl font-extrabold text-emerald-600">{{ $done }}</p>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-2xl p-1.5 w-fit mb-6">
                    <button onclick="filterTasks('all')" id="filter-all"
                            class="px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-600 text-white transition-all duration-150">
                        All ({{ $total }})
                    </button>
                    <button onclick="filterTasks('todo')" id="filter-todo"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-all duration-150">
                        To Do ({{ $todo }})
                    </button>
                    <button onclick="filterTasks('in_progress')" id="filter-in_progress"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-all duration-150">
                        In Progress ({{ $inProgress }})
                    </button>
                    <button onclick="filterTasks('done')" id="filter-done"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-all duration-150">
                        Done ({{ $done }})
                    </button>
                </div>

                <!-- Task Cards -->
                <div class="space-y-3" id="tasks-container">
                    @foreach($tasks as $task)
                        <div class="task-card group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 hover:shadow-md transition-all duration-200"
                             data-status="{{ $task->status }}">
                            <!-- Priority stripe -->
                            <div class="flex items-stretch">
                                <div class="w-1 flex-shrink-0 {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-orange-400' : 'bg-blue-400') }}"></div>
                                <div class="flex-1 p-5">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">

                                            <!-- Badges row -->
                                            <div class="flex flex-wrap gap-1.5 mb-2.5">
                                                {{-- Status --}}
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

                                                {{-- Priority --}}
                                                @if($task->priority === 'high')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">High</span>
                                                @elseif($task->priority === 'medium')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">Medium</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Low</span>
                                                @endif

                                                {{-- Urgency --}}
                                                @if($task->deadline->isPast() && $task->status !== 'done')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">Overdue</span>
                                                @elseif(!$task->deadline->isPast() && $task->deadline->diffInHours(now()) <= 48 && $task->status !== 'done')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Due Soon</span>
                                                @endif
                                            </div>

                                            <!-- Title & description -->
                                            <a href="{{ route('projects.tasks.show', [$project, $task]) }}"
                                               class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors leading-snug">
                                                {{ $task->title }}
                                            </a>
                                            @if($task->description)
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $task->description }}</p>
                                            @endif

                                            <!-- Meta row -->
                                            <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}
                                                </span>
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $task->deadline->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            @can('updateStatus', $task)
                                                <form action="{{ route('tasks.updateStatus', [$project, $task]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <select onchange="this.form.submit()" name="status"
                                                            class="text-xs border-2 border-gray-200 rounded-xl px-2.5 py-2 bg-white focus:border-indigo-500 focus:ring-indigo-500 cursor-pointer font-medium text-gray-700 hover:border-indigo-300 transition-colors">
                                                        <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>To Do</option>
                                                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                                    </select>
                                                </form>
                                            @endcan

                                            @can('update', $task)
                                                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                                                   class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @endcan

                                            <a href="{{ route('projects.tasks.show', [$project, $task]) }}"
                                               class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center text-center py-24 px-6 bg-white rounded-2xl border border-gray-200">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-5 border-2 border-indigo-100">
                        <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2">No tasks yet</h3>
                    <p class="text-sm text-gray-500 mb-6 max-w-xs">Create the first task for this project and start tracking progress.</p>
                    @can('create', [App\Models\Task::class, $project])
                        <a href="{{ route('projects.tasks.create', $project) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create First Task
                        </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>

    <script>
        function filterTasks(status) {
            document.querySelectorAll('.task-card').forEach(card => {
                card.style.display = (status === 'all' || card.dataset.status === status) ? 'block' : 'none';
            });
            document.querySelectorAll('[id^="filter-"]').forEach(btn => {
                btn.className = 'px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-all duration-150';
            });
            document.getElementById('filter-' + status).className = 'px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-600 text-white transition-all duration-150';
        }
    </script>
</x-app-layout>
