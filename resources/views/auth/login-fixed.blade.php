<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bimasada Invoice Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-white font-poppins">
    <div class="relative min-h-screen bg-white overflow-hidden">
        
        <!-- Logo Fixed Top Left -->
        <div class="fixed top-12 left-12 z-50">
            <img src="{{ asset('assets/bimasadalogo.png') }}" alt="Bimasada Logo" class="h-12 w-auto">
        </div>

        <!-- Main Container: Two Column Layout -->
        <div class="min-h-screen flex items-center justify-center px-4 py-24 lg:px-12">
            <div class="w-full max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <!-- LEFT SIDE: Form Login -->
                    <div class="w-full max-w-[582px] mx-auto lg:mx-0">
                        
                        <!-- Header Text -->
                        <div class="mb-8">
                            <h1 class="text-5xl font-semibold text-black leading-tight mb-0">
                                Selamat Datang di Sistem<br/>Informasi<br/>Invoice Management
                            </h1>
                        </div>
                        
                        <!-- Subtitle -->
                        <div class="mb-10">
                            <p class="text-lg font-medium text-secondary leading-relaxed">
                                Silahkan masukkan nama, kode karyawan, dan password untuk masuk ke dalam akun Anda.
                            </p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <x-alert variant="success" class="mb-4">
                                {{ session('status') }}
                            </x-alert>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Input Email menggunakan komponen x-input -->
                            <div>
                                <x-input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    placeholder="Masukkan Email Anda"
                                    :value="old('email')"
                                    required 
                                    autofocus
                                    autocomplete="username"
                                    class="h-[61px] text-primary placeholder-primary border-2 border-primary rounded-[20px] focus:border-primary focus:ring-primary"
                                />
                                @error('email')
                                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Input Password menggunakan komponen x-input -->
                            <div>
                                <x-input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    placeholder="Masukkan Password"
                                    required
                                    autocomplete="current-password"
                                    class="h-[61px] text-primary placeholder-primary border-2 border-primary rounded-[20px] focus:border-primary focus:ring-primary"
                                />
                                @error('password')
                                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me (hidden untuk clean UI) -->
                            <input type="hidden" name="remember" value="1">

                            <!-- Login Button menggunakan komponen x-button -->
                            <div class="pt-6">
                                <x-button 
                                    type="submit" 
                                    variant="primary"
                                    class="w-full h-[69px] text-lg font-bold rounded-[20px] bg-primary hover:bg-primary-dark"
                                >
                                    Log In
                                </x-button>
                            </div>
                        </form>

                    </div>

                    <!-- RIGHT SIDE: Illustration Image -->
                    <div class="hidden lg:flex items-center justify-center">
                        <img 
                            src="{{ asset('assets/loginimage.png') }}" 
                            alt="Warehouse Forklift Illustration" 
                            class="w-full max-w-[778px] h-auto object-contain"
                        />
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
