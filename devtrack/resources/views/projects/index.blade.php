<x-app-layout>
    @section('breadcrumbs')
        <nav class="flex items-center text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900">Projects</span>
        </nav>
    @endsection

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if($projects->count() > 0)
                @php
                    $totalTasks = $projects->sum(fn($p) => $p->tasks->count());
                    $doneTasks  = $projects->sum(fn($p) => $p->tasks->where('status', 'done')->count());
                    $inProgress = $projects->sum(fn($p) => $p->tasks->where('status', 'in_progress')->count());
                @endphp

                <!-- Page Header with Search -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 animate-fade-in">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Projects</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage and track all your projects</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Search (UI Only) -->
                        <div class="relative hidden md:block">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" placeholder="Search projects..." class="pl-10 pr-4 py-2.5 w-64 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0 text-sm transition-colors">
                        </div>
                        <a href="{{ route('projects.create') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            New Project
                        </a>
                    </div>
                </div>

                <!-- Stats Row with Modern Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="card-modern p-5 animate-slide-up" style="animation-delay: 0ms">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Projects</p>
                            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $projects->count() }}</p>
                        <p class="text-xs text-indigo-600 font-medium mt-1">Active</p>
                    </div>

                    <div class="card-modern p-5 animate-slide-up" style="animation-delay: 50ms">
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

                    <div class="card-modern p-5 animate-slide-up border-yellow-200" style="animation-delay: 100ms">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-yellow-500 uppercase tracking-wider">In Progress</p>
                            <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold text-yellow-600">{{ $inProgress }}</p>
                        <p class="text-xs text-yellow-500 font-medium mt-1">Being worked on</p>
                    </div>

                    <div class="card-modern p-5 animate-slide-up border-emerald-200" style="animation-delay: 150ms">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wider">Completed</p>
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold text-emerald-600">{{ $doneTasks }}</p>
                        <p class="text-xs text-emerald-500 font-medium mt-1">Tasks done</p>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($projects as $project)
                        @php
                            $pTotal    = $project->tasks->count();
                            $pDone     = $project->tasks->where('status', 'done')->count();
                            $pProgress = $pTotal > 0 ? round(($pDone / $pTotal) * 100) : 0;
                            $isOverdue = $project->deadline->isPast() && $project->tasks->where('status', '!=', 'done')->count() > 0;
                            $isLead    = auth()->user()->can('update', $project);
                        @endphp

                        <div class="card-modern group overflow-hidden animate-scale-in" style="animation-delay: {{ $loop->index * 50 }}ms">
                            <!-- Top accent stripe -->
                            <div class="h-1 {{ $isOverdue ? 'bg-red-500' : ($pProgress === 100 && $pTotal > 0 ? 'bg-emerald-500' : 'bg-indigo-500') }}"></div>

                            <div class="p-5 flex-1 flex flex-col">
                                <!-- Title row -->
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap gap-1.5 mb-2">
                                            @if($isLead)
                                                <span class="badge-indigo">Lead</span>
                                            @else
                                                <span class="badge-info">Member</span>
                                            @endif
                                            @if($isOverdue)
                                                <span class="badge-danger">Overdue</span>
                                            @elseif($pProgress === 100 && $pTotal > 0)
                                                <span class="badge-success">Complete</span>
                                            @endif
                                        </div>
                                        <h3 class="text-base font-bold text-gray-900 group-hover:text-indigo-600 transition-colors leading-snug">
                                            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                                        </h3>
                                    </div>
                                    @if($isLead)
                                        <a href="{{ route('projects.edit', $project) }}"
                                           class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 transition-all opacity-0 group-hover:opacity-100 micro-lift">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 111.414 1.414L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>

                                @if($project->description)
                                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mb-4">{{ $project->description }}</p>
                                @endif

                                <!-- Progress -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs font-semibold mb-1.5">
                                        <span class="text-gray-500">Progress</span>
                                        <span class="{{ $pProgress === 100 && $pTotal > 0 ? 'text-emerald-600' : 'text-indigo-600' }}">{{ $pProgress }}%</span>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-1.5 rounded-full transition-all duration-500 {{ $pProgress === 100 && $pTotal > 0 ? 'bg-emerald-500' : 'bg-indigo-500' }}"
                                             style="width: {{ $pProgress }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">{{ $pDone }} of {{ $pTotal }} tasks done</p>
                                </div>

                                <!-- Footer meta -->
                                <div class="flex items-center justify-between text-xs text-gray-400 mt-auto pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="{{ $isOverdue ? 'text-red-600 font-semibold' : '' }}">{{ $project->deadline->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $project->members->count() }} {{ Str::plural('member', $project->members->count()) }}
                                    </div>
                                    <a href="{{ route('projects.show', $project) }}"
                                       class="flex items-center gap-1 text-indigo-600 font-semibold hover:text-indigo-800 transition-colors">
                                        Open
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center text-center py-20 bg-white rounded-2xl border border-gray-200 animate-fade-in">
                    <div class="w-20 h-20 bg-indigo-50 rounded-3xl flex items-center justify-center mb-6 border-2 border-indigo-100">
                        <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">No projects yet</h3>
                    <p class="text-sm text-gray-500 mb-8 max-w-sm">Create your first project to start assigning tasks and tracking your team's progress.</p>
                    <a href="{{ route('projects.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create First Project
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
