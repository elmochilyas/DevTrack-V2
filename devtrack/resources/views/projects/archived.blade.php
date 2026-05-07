<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900 tracking-tight">Archived Projects</h1>
                <p class="text-sm text-gray-500 mt-0.5">Restore or permanently delete archived projects</p>
            </div>
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 transition-colors w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Projects
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($projects as $project)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col opacity-80 hover:opacity-100 transition-opacity">
                            <div class="h-1 bg-gray-400"></div>
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-500 mb-2 inline-block">Archived</span>
                                        <h3 class="text-base font-bold text-gray-700 leading-snug">{{ $project->title }}</h3>
                                    </div>
                                </div>

                                @if($project->description)
                                    <p class="text-sm text-gray-400 leading-relaxed line-clamp-2 mb-4">{{ $project->description }}</p>
                                @endif

                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-4 mt-auto pt-4 border-t border-gray-100">
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
                                                class="w-full px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('projects.forceDelete', $project->id) }}" method="POST"
                                          onsubmit="return confirm('Permanently delete this project? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold rounded-lg border border-red-200 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center text-center py-20 bg-white rounded-2xl border border-gray-200">
                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-5 border-2 border-gray-100">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2">No archived projects</h3>
                    <p class="text-sm text-gray-500 mb-6 max-w-xs">Projects you archive will appear here.</p>
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors">
                        Back to Projects
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
