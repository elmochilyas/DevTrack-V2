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
            <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 bg-gradient-to-br from-slate-900 via-indigo-950 to-violet-900 relative overflow-hidden flex-col justify-between p-12">
                <!-- Dot-grid texture -->
                <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 24px 24px;"></div>
                <!-- Glow orbs -->
                <div class="absolute top-1/4 right-1/3 w-96 h-96 bg-indigo-600/25 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-1/3 left-1/4 w-72 h-72 bg-violet-600/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-3/4 right-1/4 w-48 h-48 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Logo -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold text-white tracking-tight">DevTrack</span>
                    </div>
                </div>

                <!-- Center Content -->
                <div class="relative z-10 max-w-md">
                    <!-- Pill badge -->
                    <div class="inline-flex items-center gap-2 bg-white/8 border border-white/15 rounded-full px-3.5 py-1.5 mb-6">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse-soft"></span>
                        <span class="text-xs font-semibold text-indigo-200 tracking-wide">Built for dev teams</span>
                    </div>

                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-4">
                        Ship projects<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-violet-300">on time, every time.</span>
                    </h1>
                    <p class="text-indigo-200/75 text-base leading-relaxed mb-8">
                        Track tasks, manage teams, and hit deadlines — all in one clean workspace built for developers.
                    </p>

                    <!-- Mock Dashboard Widget -->
                    <div class="bg-white/6 backdrop-blur-sm border border-white/10 rounded-2xl p-5 mb-6 shadow-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-lg flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">A</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-white">API Redesign</p>
                                    <p class="text-xs text-indigo-300/70">3 members · Due Jan 15</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-indigo-300 bg-indigo-500/20 px-2.5 py-1 rounded-lg">78%</span>
                        </div>
                        <div class="h-1.5 bg-white/10 rounded-full mb-4 overflow-hidden">
                            <div class="h-1.5 bg-gradient-to-r from-indigo-400 to-violet-400 rounded-full transition-all" style="width: 78%"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-2.5">
                            <div class="bg-white/5 rounded-xl p-2.5 text-center border border-white/5">
                                <p class="text-base font-extrabold text-white">12</p>
                                <p class="text-xs text-indigo-300/70 mt-0.5">Tasks</p>
                            </div>
                            <div class="bg-emerald-500/10 rounded-xl p-2.5 text-center border border-emerald-500/20">
                                <p class="text-base font-extrabold text-emerald-400">9</p>
                                <p class="text-xs text-indigo-300/70 mt-0.5">Done</p>
                            </div>
                            <div class="bg-yellow-500/10 rounded-xl p-2.5 text-center border border-yellow-500/20">
                                <p class="text-base font-extrabold text-yellow-400">3</p>
                                <p class="text-xs text-indigo-300/70 mt-0.5">Active</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature pills -->
                    <div class="flex flex-wrap gap-2">
                        <div class="flex items-center gap-1.5 bg-white/8 border border-white/10 rounded-full px-3.5 py-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-xs text-white/80 font-medium">Task tracking</span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/8 border border-white/10 rounded-full px-3.5 py-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-xs text-white/80 font-medium">Team roles</span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/8 border border-white/10 rounded-full px-3.5 py-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-xs text-white/80 font-medium">Deadline alerts</span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/8 border border-white/10 rounded-full px-3.5 py-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-xs text-white/80 font-medium">REST API</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom -->
                <div class="relative z-10">
                    <p class="text-indigo-400/50 text-xs font-medium">Built for dev teams at startups · Powered by Laravel</p>
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
