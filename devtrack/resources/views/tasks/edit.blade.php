<x-app-layout>

    <div class="py-8 md:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Task Information</h3>
                </div>
                <div class="p-6 md:p-8">
                    <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Task Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Task Title</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <input id="title"
                                       type="text"
                                       name="title"
                                       value="{{ old('title', $task->title) }}"
                                       class="pl-10 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-gray-900 placeholder-gray-400 transition-colors"
                                       required
                                       autofocus>
                            </div>
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Task Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description
                                <span class="font-normal text-gray-400 ml-1">(optional)</span>
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-gray-900 placeholder-gray-400 transition-colors resize-none"
                                      placeholder="Describe the task in detail">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Task Deadline -->
                            <div>
                                <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">Deadline</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input id="deadline"
                                           type="datetime-local"
                                           name="deadline"
                                           value="{{ old('deadline', $task->deadline->format('Y-m-d\TH:i')) }}"
                                           class="pl-10 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-gray-900 transition-colors"
                                           required>
                                </div>
                                <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                            </div>

                            <!-- Task Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                                <select id="priority"
                                        name="priority"
                                        class="block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-gray-900 transition-colors"
                                        required>
                                    <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Assign To -->
                        <div class="mb-6">
                            <label for="assigned_to" class="block text-sm font-semibold text-gray-700 mb-2">
                                Assign To
                                <span class="font-normal text-gray-400 ml-1">(optional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <select id="assigned_to"
                                        name="assigned_to"
                                        class="pl-10 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-gray-900 transition-colors">
                                    <option value="">— Unassigned —</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ ucfirst($member->pivot->role) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                        </div>

                        <!-- Status (lead only via updateStatus policy) -->
                        @can('updateStatus', $task)
                            <div class="mb-8">
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select id="status"
                                        name="status"
                                        class="block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 text-gray-900 transition-colors">
                                    <option value="todo" {{ old('status', $task->status) === 'todo' ? 'selected' : '' }}>To Do</option>
                                    <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        @endcan

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                            <a href="{{ route('projects.tasks.show', [$project, $task]) }}"
                               class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            @can('delete', $task)
                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                        <h3 class="text-base font-bold text-red-800">Danger Zone</h3>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Delete this task</p>
                            <p class="text-sm text-gray-500 mt-1">This action is permanent and cannot be undone.</p>
                        </div>
                        <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" onsubmit="return confirm('Delete this task permanently?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
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
</x-app-layout>
