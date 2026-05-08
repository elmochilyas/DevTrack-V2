<x-app-layout>

    <div class="py-8 md:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Project Information</h3>
                </div>
                <div class="p-6 md:p-8">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf

                        <!-- Project Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Project Title
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                </div>
                                <x-text-input id="title" 
                                             type="text" 
                                             name="title" 
                                             value="{{ old('title') }}"
                                             class="pl-10"
                                             placeholder="Enter project title"
                                             required 
                                             autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Project Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description
                            </label>
                            <div class="relative">
                                <textarea id="description" 
                                          name="description" 
                                          rows="4"
                                          class="block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-gray-900 placeholder-gray-400 transition-colors resize-none" 
                                          placeholder="Describe the project goals and scope">{{ old('description') }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Project Deadline -->
                        <div class="mb-8">
                            <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                                Project Deadline
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input id="deadline" 
                                       type="datetime-local" 
                                       name="deadline" 
                                       value="{{ old('deadline') }}"
                                       class="pl-10 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-gray-900 transition-colors" 
                                       required>
                            </div>
                            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Set a realistic deadline to keep the team on track
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <a href="{{ route('projects.index') }}" 
                               class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-200 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('Create Project') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="mt-6 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6">
                <div class="flex">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 mr-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-900 mb-2">Tips for creating a project:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-start text-sm text-blue-800">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Choose a clear, descriptive title
                            </li>
                            <li class="flex items-start text-sm text-blue-800">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Define the project scope in the description
                            </li>
                            <li class="flex items-start text-sm text-blue-800">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Set a deadline to keep the team on track
                            </li>
                            <li class="flex items-start text-sm text-blue-800">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 011.414-1.414L9 8.586l2.293-2.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                You'll be automatically added as the Project Lead
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
