@extends('layouts.app')

@section('title', 'Serviços - VPPR')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    <nav class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-semibold text-slate-900 dark:text-white">VPPR</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Dashboard
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
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Serviços</h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">Gerencie os serviços cadastrados.</p>
            </div>
            <button 
                id="btn-new-service"
                class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 transition-all duration-200"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Serviço
            </button>
        </div>

        <div id="alert-success" class="hidden mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span id="alert-success-text" class="text-sm text-green-600 dark:text-green-400"></span>
            </div>
        </div>

        <div id="alert-error" class="hidden mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="alert-error-text" class="text-sm text-red-600 dark:text-red-400"></span>
            </div>
        </div>

        <div id="loading" class="flex justify-center py-12">
            <svg class="w-8 h-8 animate-spin text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <div id="empty-state" class="hidden text-center py-12">
            <div class="mx-auto w-16 h-16 bg-slate-200 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">Nenhum serviço cadastrado</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-6">Comece cadastrando seu primeiro serviço.</p>
            <button 
                id="btn-new-service-empty"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-all duration-200"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Serviço
            </button>
        </div>

        <div id="services-table-container" class="hidden bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Nome
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Valor
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Descrição
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody id="services-tbody" class="divide-y divide-slate-200 dark:divide-slate-700">
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div id="modal-service" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div id="modal-backdrop" class="fixed inset-0 bg-slate-900/60 transition-opacity"></div>

        <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg mx-auto transform transition-all">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700">
                <h3 id="modal-title" class="text-lg font-semibold text-slate-900 dark:text-white">Novo Serviço</h3>
                <button id="modal-close" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="service-form" class="p-6 space-y-5">
                <input type="hidden" id="service-id" value="">

                <div id="modal-error" class="hidden p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
                    <span id="modal-error-text" class="text-sm text-red-600 dark:text-red-400"></span>
                </div>

                <div>
                    <label for="service-name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Nome do Serviço
                    </label>
                    <input 
                        type="text" 
                        id="service-name" 
                        name="name" 
                        required
                        placeholder="Ex: Consultoria"
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                    >
                </div>

                <div>
                    <label for="service-value" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Valor (R$)
                    </label>
                    <input 
                        type="number" 
                        id="service-value" 
                        name="value" 
                        required
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                    >
                </div>

                <div>
                    <label for="service-description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Descrição
                    </label>
                    <textarea 
                        id="service-description" 
                        name="description" 
                        rows="3"
                        placeholder="Descreva o serviço..."
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 resize-none"
                    ></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button 
                        type="button" 
                        id="modal-cancel"
                        class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-xl transition-all duration-200"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="submit" 
                        id="modal-submit"
                        class="flex-1 py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span id="modal-submit-text">Salvar</span>
                        <svg id="modal-submit-spinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-delete" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div id="modal-delete-backdrop" class="fixed inset-0 bg-slate-900/60 transition-opacity"></div>

        <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md mx-auto transform transition-all">
            <div class="p-6 text-center">
                <div class="mx-auto w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Excluir Serviço</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">
                    Tem certeza que deseja excluir <span id="delete-service-name" class="font-medium text-slate-700 dark:text-slate-300"></span>? Esta ação não pode ser desfeita.
                </p>
                <input type="hidden" id="delete-service-id" value="">

                <div class="flex gap-3">
                    <button 
                        type="button" 
                        id="modal-delete-cancel"
                        class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-xl transition-all duration-200"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="button" 
                        id="modal-delete-confirm"
                        class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-lg shadow-red-500/30 hover:shadow-red-500/40 transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span id="delete-btn-text">Excluir</span>
                        <svg id="delete-btn-spinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/services.js')
@endpush
