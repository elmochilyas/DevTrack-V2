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
            <span class="text-gray-900">Archived</span>
        </nav>
    @endsection

    <x-slot name="navActions">
        <a href="{{ route('projects.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-indigo-300 hover:text-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Projects
        </a>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Page Header -->
            <div class="mb-8 animate-fade-in">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Archived Projects</h1>
                <p class="mt-1 text-sm text-gray-500">Restore projects or permanently delete them</p>
            </div>

            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($projects as $project)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:border-gray-300 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 animate-scale-in" style="animation-delay: {{ $loop->index * 50 }}ms">
                            <div class="h-1 bg-gray-400"></div>
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <span class="inline-block px-2.5 py-0.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-500 mb-2">Archived</span>
                                        <h3 class="text-base font-bold text-gray-700 leading-snug">{{ $project->title }}</h3>
                                    </div>
                                </div>

                                @if($project->description)
                                    <p class="text-sm text-gray-400 leading-relaxed line-clamp-2 mb-4">{{ $project->description }}</p>
                                @endif

                                <div class="flex items-center gap-1 text-xs text-gray-400 mb-4 mt-auto pt-4 border-t border-gray-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Deadline: {{ $project->deadline->format('M d, Y') }}</span>
                                </div>

                                <div class="flex gap-2">
                                    <form action="{{ route('projects.restore', $project->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="w-full px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('projects.forceDelete', $project->id) }}" method="POST"
                                          onsubmit="return confirm('Permanently delete this project? This cannot be undone.')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold rounded-xl border border-red-200 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center text-center py-20 bg-white rounded-2xl border border-gray-200 animate-fade-in">
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mb-6 border-2 border-gray-100">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2">No archived projects</h3>
                    <p class="text-sm text-gray-500 mb-8 max-w-sm">Projects you archive will appear here.</p>
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        Back to Projects
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
