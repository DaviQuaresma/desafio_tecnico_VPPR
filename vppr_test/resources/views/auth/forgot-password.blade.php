@extends('layouts.app')

@section('title', 'Redefinir Senha - VPPR')

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
                Recupere seu<br>
                <span class="text-vppr-gold-500">acesso com segurança.</span>
            </h2>
            
            <p class="text-vppr-navy-500/90 text-lg max-w-md mt-4">
                Informe seu e-mail cadastrado e crie uma nova senha para continuar acessando sua conta.
            </p>
            
            <div class="mt-12 p-6 rounded-xl bg-vppr-navy-800/50 border border-vppr-navy-700/50">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-vppr-gold-500/20 flex items-center justify-center shrink-0">
                        <x-icons.lock class="w-5 h-5 text-vppr-gold-500" />
                    </div>
                    <div>
                        <h4 class="text-white font-medium">Dica de segurança</h4>
                        <p class="text-white/60 text-sm mt-1">
                            Crie uma senha forte com letras maiúsculas, minúsculas, números e símbolos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
        <div class="w-full max-w-md">
            <div class="lg:hidden mb-10">
                <x-logo class="h-10 mx-auto" variant="dark" />
            </div>

            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-vppr-navy-600 hover:text-vppr-navy-900 transition-colors mb-8">
                <x-icons.chevron-left class="w-4 h-4" />
                <span class="text-sm">Voltar ao login</span>
            </a>

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-vppr-navy-900">
                    Redefinir senha
                </h1>
                <p class="mt-2 text-vppr-navy-600">
                    Informe seu e-mail e crie uma nova senha
                </p>
            </div>

            <form id="forgot-password-form" class="space-y-5">
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
                        Nova senha
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
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-vppr-navy-800 mb-1.5">
                        Confirmar nova senha
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
                            placeholder="Repita a nova senha"
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
                    <span id="btn-text">Redefinir senha</span>
                    <x-icons.chevron-right id="btn-icon" class="w-5 h-5" />
                    <x-icons.loader id="btn-spinner" class="w-5 h-5 hidden" />
                </button>
            </form>

            <p class="mt-10 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} VPPR Consultoria Jurídica Empresarial.<br>
                Todos os direitos reservados.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/auth/forgot-password.js')
@endpush
