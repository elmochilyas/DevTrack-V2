<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DevTrack') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">

            <!-- Left Panel — Branding -->
            <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 bg-gradient-to-br from-indigo-900 via-indigo-800 to-violet-900 relative overflow-hidden flex-col justify-between p-12">
                <!-- Background decoration -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-80 h-80 bg-violet-400 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                    <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-400 rounded-full -translate-y-1/2"></div>
                </div>

                <!-- Logo -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">DevTrack</span>
                    </div>
                </div>

                <!-- Center Content -->
                <div class="relative z-10 max-w-md">
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-6">
                        Manage projects.<br>
                        Ship faster.
                    </h1>
                    <p class="text-indigo-200 text-lg leading-relaxed mb-10">
                        A simple, powerful tool for dev teams to track tasks, assign work, and stay on deadline — no complexity, just clarity.
                    </p>

                    <!-- Feature pills -->
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm text-white font-medium">Task tracking</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm text-white font-medium">Team roles</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm text-white font-medium">Deadline alerts</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm text-white font-medium">REST API</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom quote -->
                <div class="relative z-10">
                    <p class="text-indigo-300 text-sm">Built for dev teams at startups · Powered by Laravel</p>
                </div>
            </div>

            <!-- Right Panel — Form -->
            <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 sm:p-12 bg-white">
                <div class="w-full max-w-md">

                    <!-- Mobile logo -->
                    <div class="flex items-center gap-2.5 mb-10 lg:hidden">
                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold text-gray-900 tracking-tight">Dev<span class="text-indigo-600">Track</span></span>
                    </div>

                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
