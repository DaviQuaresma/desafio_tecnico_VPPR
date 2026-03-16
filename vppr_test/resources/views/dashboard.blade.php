@extends('layouts.app')

@section('title', 'Dashboard - VPPR')

@section('content')
<div class="min-h-screen bg-gray-50">
    <nav class="bg-vppr-navy-900 border-b border-vppr-navy-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <x-logo class="h-8" variant="light" />
                    
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-vppr-navy-800 rounded-lg flex items-center gap-2">
                            <x-icons.layout-dashboard class="w-4 h-4" />
                            Dashboard
                        </a>
                        <a href="{{ route('services') }}" class="px-4 py-2 text-sm font-medium text-vppr-navy-500 hover:text-white hover:bg-vppr-navy-800 rounded-lg transition-colors flex items-center gap-2">
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
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-vppr-navy-900">
                Bem-vindo ao <span class="text-vppr-gold-600">VPPR</span>
            </h1>
            <p class="mt-1 text-vppr-navy-600">
                Gerencie seus serviços e acompanhe suas atividades.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('services') }}" class="group bg-white rounded-xl border border-gray-200 p-6 hover:border-vppr-blue-500 hover:shadow-lg transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-vppr-navy-600">Total de Serviços</p>
                        <p id="services-count" class="text-3xl font-bold text-vppr-navy-900 mt-2">-</p>
                    </div>
                    <div class="w-12 h-12 bg-vppr-blue-500/10 rounded-lg flex items-center justify-center group-hover:bg-vppr-blue-500 transition-colors">
                        <x-icons.briefcase class="w-6 h-6 text-vppr-blue-600 group-hover:text-white transition-colors" />
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-vppr-blue-600 font-medium">
                    <span>Ver todos</span>
                    <x-icons.chevron-right class="w-4 h-4 ml-1" />
                </div>
            </a>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-vppr-navy-600">Status do Sistema</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">Online</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <x-icons.check class="w-6 h-6 text-green-600" />
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-sm text-vppr-navy-600">API funcionando normalmente</span>
                </div>
            </div>

            <div class="bg-gradient-to-br from-vppr-navy-900 to-vppr-navy-800 rounded-xl p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-vppr-gold-500/20"></div>
                
                <div class="relative">
                    <p class="text-sm font-medium text-white/70">Ação Rápida</p>
                    <p class="text-xl font-bold mt-2">Novo Serviço</p>
                    <a href="{{ route('services') }}?new=1" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-vppr-gold-500 hover:bg-vppr-gold-400 text-vppr-navy-900 font-medium rounded-lg transition-colors">
                        <x-icons.plus class="w-4 h-4" />
                        Criar
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-vppr-navy-900">Informações da API</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-vppr-navy-100 flex items-center justify-center">
                            <x-icons.chevron-right class="w-4 h-4 text-vppr-navy-600" />
                        </div>
                        <span class="text-sm text-vppr-navy-600">Endpoint Base</span>
                    </div>
                    <code class="px-3 py-1.5 bg-vppr-navy-900 text-vppr-gold-500 text-sm rounded-lg font-mono">/api</code>
                </div>
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-vppr-navy-100 flex items-center justify-center">
                            <x-icons.lock class="w-4 h-4 text-vppr-navy-600" />
                        </div>
                        <span class="text-sm text-vppr-navy-600">Autenticação</span>
                    </div>
                    <span class="px-3 py-1.5 bg-green-100 text-green-700 text-sm rounded-lg font-medium">JWT Token</span>
                </div>
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-vppr-navy-100 flex items-center justify-center">
                            <x-icons.briefcase class="w-4 h-4 text-vppr-navy-600" />
                        </div>
                        <span class="text-sm text-vppr-navy-600">Serviços CRUD</span>
                    </div>
                    <code class="px-3 py-1.5 bg-vppr-navy-900 text-vppr-gold-500 text-sm rounded-lg font-mono">/api/services</code>
                </div>
            </div>
        </div>
    </main>

    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <p class="text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} VPPR Consultoria Jurídica Empresarial. Todos os direitos reservados.
        </p>
    </footer>
</div>
@endsection

@push('scripts')
    @vite('resources/js/dashboard.js')
@endpush
