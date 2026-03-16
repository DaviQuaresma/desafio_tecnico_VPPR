@extends('layouts.app')

@section('title', 'Criar Conta - VPPR')

@section('content')
<div class="min-h-screen flex">
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-vppr-navy-900 via-vppr-navy-800 to-vppr-navy-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-vppr-gold-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-vppr-blue-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="absolute top-20 right-20 w-16 h-16 bg-vppr-gold-500"></div>
        <div class="absolute bottom-32 left-24 w-8 h-8 bg-vppr-gold-500/60"></div>
        
        <div class="relative z-10 flex flex-col justify-center px-16 py-12">
            <x-logo class="h-12 mb-12" variant="light" />
            
            <h2 class="text-4xl font-bold text-white leading-tight mb-4">
                Junte-se a nós<br>
                <span class="text-vppr-gold-500">e evolua seu negócio.</span>
            </h2>
            
            <p class="text-vppr-navy-500/90 text-lg max-w-md mt-4">
                Crie sua conta e tenha acesso completo à nossa plataforma de gestão de serviços jurídicos.
            </p>
            
            <div class="mt-12 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-vppr-gold-500/20 flex items-center justify-center">
                        <x-icons.check class="w-4 h-4 text-vppr-gold-500" />
                    </div>
                    <span class="text-white/80">Gestão completa de serviços</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-vppr-gold-500/20 flex items-center justify-center">
                        <x-icons.check class="w-4 h-4 text-vppr-gold-500" />
                    </div>
                    <span class="text-white/80">Dashboard intuitivo</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-vppr-gold-500/20 flex items-center justify-center">
                        <x-icons.check class="w-4 h-4 text-vppr-gold-500" />
                    </div>
                    <span class="text-white/80">Suporte dedicado</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
        <div class="w-full max-w-md">
            <div class="lg:hidden mb-10">
                <x-logo class="h-10 mx-auto" variant="dark" />
            </div>

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-vppr-navy-900">
                    Criar conta
                </h1>
                <p class="mt-2 text-vppr-navy-600">
                    Preencha os dados para criar sua conta
                </p>
            </div>

            <form id="register-form" class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Nome completo
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-icons.user class="w-5 h-5 text-vppr-navy-500" />
                        </div>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            placeholder="Seu nome"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        E-mail
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-icons.mail class="w-5 h-5 text-vppr-navy-500" />
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            placeholder="seu@email.com"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Senha
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-icons.lock class="w-5 h-5 text-vppr-navy-500" />
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            placeholder="Mínimo 8 caracteres"
                            class="w-full pl-11 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all"
                        >
                        <button 
                            type="button" 
                            data-toggle-password="password"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-vppr-navy-500 hover:text-vppr-navy-700 transition-colors"
                        >
                            <x-icons.eye class="eye-icon w-5 h-5" />
                            <x-icons.eye-off class="eye-off-icon w-5 h-5 hidden" />
                        </button>
                    </div>
                    <div id="password-strength" class="mt-2 hidden">
                        <div class="flex gap-1">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 strength-bar"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 strength-bar"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 strength-bar"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 strength-bar"></div>
                        </div>
                        <p id="password-strength-text" class="text-xs mt-1 text-gray-500"></p>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Confirmar senha
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-icons.lock class="w-5 h-5 text-vppr-navy-500" />
                        </div>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            placeholder="Repita a senha"
                            class="w-full pl-11 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-lg text-vppr-navy-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:border-transparent transition-all"
                        >
                        <button 
                            type="button" 
                            data-toggle-password="password_confirmation"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-vppr-navy-500 hover:text-vppr-navy-700 transition-colors"
                        >
                            <x-icons.eye class="eye-icon w-5 h-5" />
                            <x-icons.eye-off class="eye-off-icon w-5 h-5 hidden" />
                        </button>
                    </div>
                </div>

                <button 
                    type="submit" 
                    id="submit-btn"
                    class="w-full py-3 px-4 bg-vppr-blue-600 hover:bg-vppr-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-vppr-blue-500 focus:ring-offset-2 transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <span id="btn-text">Criar conta</span>
                    <x-icons.chevron-right id="btn-icon" class="w-5 h-5" />
                    <x-icons.loader id="btn-spinner" class="w-5 h-5 hidden" />
                </button>
            </form>

            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">ou</span>
                </div>
            </div>

            <p class="text-center text-sm text-vppr-navy-600">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="font-semibold text-vppr-gold-600 hover:text-vppr-gold-700 transition-colors">
                    Fazer login
                </a>
            </p>

            <p class="mt-10 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} VPPR Consultoria Jurídica Empresarial.<br>
                Todos os direitos reservados.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/auth/register.js')
@endpush
