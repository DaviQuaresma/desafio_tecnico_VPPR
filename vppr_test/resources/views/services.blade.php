@extends('layouts.app')

@section('title', 'Serviços - VPPR')

@section('content')
<div class="min-h-screen bg-gray-50">
    <nav class="bg-vppr-navy-900 border-b border-vppr-navy-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}">
                        <x-logo class="h-8" variant="light" />
                    </a>
                    
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-vppr-navy-500 hover:text-white hover:bg-vppr-navy-800 rounded-lg transition-colors flex items-center gap-2">
                            <x-icons.layout-dashboard class="w-4 h-4" />
                            Dashboard
                        </a>
                        <a href="{{ route('services') }}" class="px-4 py-2 text-sm font-medium text-white bg-vppr-navy-800 rounded-lg flex items-center gap-2">
                            <x-icons.briefcase class="w-4 h-4" />
                            Serviços
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-3 px-4 py-2 bg-vppr-navy-800 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-vppr-gold-500/20 flex items-center justify-center">
                            <x-icons.user class="w-4 h-4 text-vppr-gold-500" />
                        </div>
                        <span id="user-name" class="text-sm text-white font-medium"></span>
                    </div>
                    
                    <button 
                        id="logout-btn"
                        class="p-2 text-vppr-navy-500 hover:text-red-400 hover:bg-vppr-navy-800 rounded-lg transition-colors"
                        title="Sair"
                    >
                        <x-icons.log-out class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-vppr-navy-900">Serviços</h1>
                <p class="mt-1 text-vppr-navy-600">Gerencie os serviços cadastrados.</p>
            </div>
            <button 
                id="btn-new-service"
                class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-5 py-2.5 bg-vppr-blue-600 hover:bg-vppr-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all"
            >
                <x-icons.plus class="w-5 h-5" />
                Novo Serviço
            </button>
        </div>

        <div id="loading" class="flex justify-center py-16">
            <x-icons.loader class="w-8 h-8 text-vppr-blue-600" />
        </div>

        <div id="empty-state" class="hidden">
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <div class="mx-auto w-16 h-16 bg-vppr-navy-100 rounded-xl flex items-center justify-center mb-4">
                    <x-icons.briefcase class="w-8 h-8 text-vppr-navy-400" />
                </div>
                <h3 class="text-lg font-semibold text-vppr-navy-900 mb-2">Nenhum serviço cadastrado</h3>
                <p class="text-vppr-navy-600 mb-6">Comece cadastrando seu primeiro serviço.</p>
                <button 
                    id="btn-new-service-empty"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-vppr-gold-500 hover:bg-vppr-gold-400 text-vppr-navy-900 font-medium rounded-lg transition-all"
                >
                    <x-icons.plus class="w-5 h-5" />
                    Novo Serviço
                </button>
            </div>
        </div>

        <div id="services-table-container" class="hidden bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-vppr-navy-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-vppr-navy-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-vppr-navy-500 uppercase tracking-wider">
                                Nome
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-vppr-navy-500 uppercase tracking-wider">
                                Valor
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-vppr-navy-500 uppercase tracking-wider">
                                Descrição
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-vppr-navy-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody id="services-tbody" class="divide-y divide-gray-100">
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div id="modal-service" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div id="modal-backdrop" class="fixed inset-0 bg-vppr-navy-900/70 transition-opacity"></div>

        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto transform transition-all">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-semibold text-vppr-navy-900">Novo Serviço</h3>
                <button id="modal-close" class="p-1 text-gray-400 hover:text-vppr-navy-900 transition-colors">
                    <x-icons.x class="w-5 h-5" />
                </button>
            </div>

            <form id="service-form" class="p-6 space-y-5">
                <input type="hidden" id="service-id" value="">

                <div>
                    <label for="service-name" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Nome do Serviço
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-icons.briefcase class="w-5 h-5 text-vppr-navy-500" />
                        </div>
                        <input 
                            type="text" 
                            id="service-name" 
                            name="name" 
                            required
                            placeholder="Ex: Consultoria Jurídica"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>

                <div>
                    <label for="service-value" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Valor (R$)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-icons.dollar-sign class="w-5 h-5 text-vppr-navy-500" />
                        </div>
                        <input 
                            type="number" 
                            id="service-value" 
                            name="value" 
                            required
                            step="0.01"
                            min="0"
                            placeholder="0.00"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>

                <div>
                    <label for="service-description" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Descrição
                    </label>
                    <textarea 
                        id="service-description" 
                        name="description" 
                        rows="3"
                        placeholder="Descreva o serviço..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all resize-none"
                    ></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button 
                        type="button" 
                        id="modal-cancel"
                        class="flex-1 py-3 px-4 bg-gray-100 hover:bg-gray-200 text-vppr-navy-700 font-medium rounded-lg transition-all"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="submit" 
                        id="modal-submit"
                        class="flex-1 py-3 px-4 bg-vppr-blue-600 hover:bg-vppr-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span id="modal-submit-text">Salvar</span>
                        <x-icons.loader id="modal-submit-spinner" class="w-5 h-5 hidden" />
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-delete" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div id="modal-delete-backdrop" class="fixed inset-0 bg-vppr-navy-900/70 transition-opacity"></div>

        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto transform transition-all">
            <div class="p-6 text-center">
                <div class="mx-auto w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <x-icons.trash class="w-7 h-7 text-red-600" />
                </div>
                <h3 class="text-lg font-semibold text-vppr-navy-900 mb-2">Excluir Serviço</h3>
                <p class="text-vppr-navy-600 mb-6">
                    Tem certeza que deseja excluir <span id="delete-service-name" class="font-semibold text-vppr-navy-900"></span>?<br>
                    <span class="text-sm text-red-600">Esta ação não pode ser desfeita.</span>
                </p>
                <input type="hidden" id="delete-service-id" value="">

                <div class="flex gap-3">
                    <button 
                        type="button" 
                        id="modal-delete-cancel"
                        class="flex-1 py-3 px-4 bg-gray-100 hover:bg-gray-200 text-vppr-navy-700 font-medium rounded-lg transition-all"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="button" 
                        id="modal-delete-confirm"
                        class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span id="delete-btn-text">Excluir</span>
                        <x-icons.loader id="delete-btn-spinner" class="w-5 h-5 hidden" />
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
