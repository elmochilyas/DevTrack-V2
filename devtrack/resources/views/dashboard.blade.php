<x-app-layout>
    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header with Gradient -->
            <div class="mb-8 animate-fade-in">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            Welcome back, <span class="gradient-text">{{ Auth::user()->name }}</span>
                        </h1>
                        <p class="mt-2 text-gray-500">Here's what's happening with your projects today.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('projects.create') }}"
                           class="btn-primary micro-lift">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            New Project
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl animate-fade-in shadow-soft">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @php
                $projects = Auth::user()->projects ?? collect();
                $totalProjects = $projects->count();
                $totalTasks = $projects->sum(fn($p) => $p->tasks->count());
                $completedTasks = $projects->sum(fn($p) => $p->tasks->where('status', 'done')->count());
                $inProgressTasks = $projects->sum(fn($p) => $p->tasks->where('status', 'in_progress')->count());
                $overdueTasks = $projects->flatMap->tasks->where('status', '!=', 'done')->filter(fn($t) => $t->deadline->isPast())->count();
                $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            @endphp

            <!-- Stats Grid with Modern Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="card-modern p-5 animate-slide-up hover:shadow-modern" style="animation-delay: 0ms">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Projects</p>
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-gray-900">{{ $totalProjects }}</p>
                    <p class="text-xs text-indigo-600 font-medium mt-1">Active projects</p>
                </div>

                <div class="card-modern p-5 animate-slide-up hover:shadow-modern" style="animation-delay: 50ms">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Tasks</p>
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-gray-900">{{ $totalTasks }}</p>
                    <p class="text-xs text-gray-400 font-medium mt-1">Across all projects</p>
                </div>

                <div class="card-modern p-5 animate-slide-up hover:shadow-modern" style="animation-delay: 100ms">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wider">Completed</p>
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-emerald-600">{{ $completedTasks }}</p>
                    <p class="text-xs text-emerald-500 font-medium mt-1">{{ $completionRate }}% completion rate</p>
                </div>

                <div class="card-modern p-5 animate-slide-up hover:shadow-modern {{ $overdueTasks > 0 ? 'border-red-200' : '' }}" style="animation-delay: 150ms">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold {{ $overdueTasks > 0 ? 'text-red-500' : 'text-gray-400' }} uppercase tracking-wider">Overdue</p>
                        <div class="w-10 h-10 {{ $overdueTasks > 0 ? 'bg-red-50' : 'bg-gray-50' }} rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $overdueTasks > 0 ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold {{ $overdueTasks > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $overdueTasks }}</p>
                    <p class="text-xs {{ $overdueTasks > 0 ? 'text-red-500' : 'text-gray-400' }} font-medium mt-1">
                        {{ $overdueTasks > 0 ? 'Needs attention' : 'All on track' }}
                    </p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Recent Projects & Tasks -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Recent Projects -->
                    <div class="card-modern overflow-hidden animate-slide-up" style="animation-delay: 200ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-gray-900">Recent Projects</h3>
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">{{ $totalProjects }}</span>
                                </div>
                                <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    View All →
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($projects->count() > 0)
                                <div class="space-y-4">
                                    @foreach($projects->take(5) as $project)
                                        @php
                                            $pTotal = $project->tasks->count();
                                            $pDone = $project->tasks->where('status', 'done')->count();
                                            $pProgress = $pTotal > 0 ? round(($pDone / $pTotal) * 100) : 0;
                                            $isOverdue = $project->deadline->isPast() && $project->tasks->where('status', '!=', 'done')->count() > 0;
                                        @endphp
                                        <a href="{{ route('projects.show', $project) }}" class="block group">
                                            <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:bg-indigo-50/30 hover:border-indigo-200 transition-all duration-200">
                                                <div class="w-2 h-12 {{ $isOverdue ? 'bg-red-500' : ($pProgress === 100 && $pTotal > 0 ? 'bg-emerald-500' : 'bg-indigo-500') }} rounded-full flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $project->title }}</h4>
                                                    <div class="flex items-center gap-4 mt-1.5">
                                                        <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                            <div class="h-1.5 rounded-full {{ $pProgress === 100 && $pTotal > 0 ? 'bg-emerald-500' : 'bg-indigo-500' }} transition-all duration-500" style="width: {{ $pProgress }}%"></div>
                                                        </div>
                                                        <span class="text-xs font-semibold {{ $pProgress === 100 && $pTotal > 0 ? 'text-emerald-600' : 'text-gray-600' }}">{{ $pProgress }}%</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3 flex-shrink-0">
                                                    <div class="text-right">
                                                        <p class="text-xs text-gray-500">Deadline</p>
                                                        <p class="text-xs font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-700' }}">{{ $project->deadline->format('M d') }}</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-indigo-50 rounded-3xl flex items-center justify-center mx-auto mb-4 border-2 border-indigo-100">
                                        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">No projects yet</h4>
                                    <p class="text-sm text-gray-500 mb-6">Create your first project to start tracking tasks.</p>
                                    <a href="{{ route('projects.create') }}" class="btn-primary">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create First Project
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Tasks -->
                    <div class="card-modern overflow-hidden animate-slide-up" style="animation-delay: 250ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-gray-900">Recent Tasks</h3>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($totalTasks > 0)
                                <div class="space-y-3">
                                    @foreach($projects->flatMap->tasks->sortByDesc('created_at')->take(10) as $task)
                                        <a href="{{ route('projects.tasks.show', [$task->project, $task]) }}" class="block group">
                                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                                <div class="w-1 h-10 {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-orange-400' : 'bg-blue-400') }} rounded-full flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $task->title }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5">{{ $task->project->title }}</p>
                                                </div>
                                                <div class="flex items-center gap-2 flex-shrink-0">
                                                    @if($task->status === 'done')
                                                        <span class="badge-success">Done</span>
                                                    @elseif($task->status === 'in_progress')
                                                        <span class="badge-warning">In Progress</span>
                                                    @else
                                                        <span class="badge-info">To Do</span>
                                                    @endif
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 text-sm">No tasks yet. Tasks will appear here once created.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar -->
                <div class="space-y-6">
                    <!-- Progress Overview -->
                    <div class="card-modern overflow-hidden animate-slide-up" style="animation-delay: 300ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Progress Overview</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center mb-6">
                                <div class="relative w-32 h-32 mb-4">
                                    <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 120 120">
                                        <circle cx="60" cy="60" r="54" fill="none" stroke="#e5e7eb" stroke-width="12"/>
                                        <circle cx="60" cy="60" r="54" fill="none" stroke="url(#progressGradient)" stroke-width="12"
                                                stroke-dasharray="339.292"
                                                stroke-dashoffset="{{ 339.292 - (339.292 * $completionRate / 100) }}"
                                                stroke-linecap="round" class="transition-all duration-1000 ease-out"/>
                                        <defs>
                                            <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#4f46e5"/>
                                                <stop offset="100%" stop-color="#7c3aed"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-3xl font-extrabold text-gray-900">{{ $completionRate }}%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500">Overall completion</p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                                        <span class="text-sm text-gray-600">To Do</span>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ $totalTasks - $completedTasks - $inProgressTasks }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                                        <span class="text-sm text-gray-600">In Progress</span>
                                    </div>
                                    <span class="text-sm font-bold text-yellow-600">{{ $inProgressTasks }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                                        <span class="text-sm text-gray-600">Completed</span>
                                    </div>
                                    <span class="text-sm font-bold text-emerald-600">{{ $completedTasks }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card-modern overflow-hidden animate-slide-up" style="animation-delay: 350ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('projects.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-colors group micro-lift">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Create Project</p>
                                    <p class="text-xs text-gray-500">Start a new project</p>
                                </div>
                            </a>

                            <a href="{{ route('projects.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-colors group micro-lift">
                                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center group-hover:bg-violet-200 transition-colors">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">View All Tasks</p>
                                    <p class="text-xs text-gray-500">Manage your tasks</p>
                                </div>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 transition-colors group micro-lift">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Profile Settings</p>
                                    <p class="text-xs text-gray-500">Update your profile</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Upcoming Deadlines -->
                    <div class="card-modern overflow-hidden animate-slide-up" style="animation-delay: 400ms">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Upcoming Deadlines</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $upcoming = $projects->flatMap->tasks
                                    ->where('status', '!=', 'done')
                                    ->sortBy('deadline')
                                    ->take(5);
                            @endphp
                            @if($upcoming->count() > 0)
                                <div class="space-y-3">
                                    @foreach($upcoming as $upTask)
                                        @php
                                            $daysLeft = now()->diffInDays($upTask->deadline, false);
                                            $isPast   = $upTask->deadline->isPast();
                                            $isSoon   = !$isPast && $daysLeft <= 2;
                                        @endphp
                                        <a href="{{ route('projects.tasks.show', [$upTask->project, $upTask]) }}"
                                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                            <div class="w-10 h-10 flex-shrink-0 rounded-xl flex items-center justify-center
                                                {{ $isPast ? 'bg-red-50' : ($isSoon ? 'bg-orange-50' : 'bg-indigo-50') }}">
                                                <svg class="w-4.5 h-4.5 {{ $isPast ? 'text-red-500' : ($isSoon ? 'text-orange-500' : 'text-indigo-500') }}"
                                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $upTask->title }}</p>
                                                <p class="text-xs text-gray-400 truncate">{{ $upTask->project->title }}</p>
                                            </div>
                                            <div class="flex-shrink-0 text-right">
                                                @if($isPast)
                                                    <span class="text-xs font-bold text-red-600">Overdue</span>
                                                @elseif($daysLeft === 0)
                                                    <span class="text-xs font-bold text-orange-600">Today</span>
                                                @elseif($daysLeft === 1)
                                                    <span class="text-xs font-bold text-orange-500">Tomorrow</span>
                                                @else
                                                    <span class="text-xs font-semibold text-gray-500">{{ $upTask->deadline->format('M d') }}</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">All caught up!</p>
                                    <p class="text-xs text-gray-400 mt-1">No pending deadlines.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
