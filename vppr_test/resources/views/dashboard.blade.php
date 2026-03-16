@extends('layouts.app')

@section('title', 'Dashboard - VPPR')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <nav class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-semibold text-slate-900 dark:text-white">VPPR</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('services') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Serviços
                    </a>
                    <span id="user-name" class="text-sm text-slate-600 dark:text-slate-400"></span>
                    <button 
                        id="logout-btn"
                        class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                    >
                        Sair
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Dashboard</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Bem-vindo ao painel de controle.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('services') }}" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-md transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total de Serviços</p>
                        <p id="services-count" class="text-2xl font-bold text-slate-900 dark:text-white">-</p>
                    </div>
                </div>
            </a>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">Online</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Última Atividade</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">Agora</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Informações da API</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Endpoint Base</span>
                    <code class="text-sm bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded text-slate-700 dark:text-slate-300">/api</code>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Autenticação</span>
                    <span class="text-sm text-green-600 dark:text-green-400 font-medium">JWT Token</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Serviços CRUD</span>
                    <code class="text-sm bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded text-slate-700 dark:text-slate-300">/api/services</code>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
    @vite('resources/js/dashboard.js')
@endpush
