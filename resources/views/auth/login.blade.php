<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bimasada Invoice Management</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .animated-gradient {
            background: linear-gradient(-45deg, #2387C0, #02245B, #5BA3D0, #1C6C9A);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .float-1 { animation: float1 6s ease-in-out infinite; }
        .float-2 { animation: float2 8s ease-in-out infinite; }
        @keyframes float1 {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-5deg); }
        }
        .input-animated:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(35, 135, 192, 0.3);
        }
        .btn-glow:hover {
            box-shadow: 0 10px 40px -10px rgba(2, 36, 91, 0.5);
        }
        .dark .btn-glow:hover {
            box-shadow: 0 10px 40px -10px rgba(35, 135, 192, 0.5);
        }
        [x-cloak] { display: none !important; }
    </style>
    
    <script>
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="h-full font-poppins" x-data="{ showPassword: false }">
    
    <div class="relative min-h-screen flex">
        
        <div class="relative flex-1 flex items-center justify-center p-6 lg:p-12 bg-secondary-50 dark:bg-dark transition-colors duration-300">
            
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="float-1 absolute -top-20 -left-20 w-72 h-72 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
                <div class="float-2 absolute -bottom-20 -right-20 w-96 h-96 bg-primary-dark/5 dark:bg-primary-dark/10 rounded-full blur-3xl"></div>
            </div>
            
            <div class="relative w-full max-w-md z-10">
                
                <div class="absolute -top-2 right-0">
                    <button type="button" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', toggle() { this.darkMode = !this.darkMode; localStorage.setItem('darkMode', this.darkMode); document.documentElement.classList.toggle('dark', this.darkMode); } }" x-init="document.documentElement.classList.toggle('dark', darkMode)" @click="toggle()" class="p-2.5 rounded-xl transition-all duration-200 hover:bg-secondary-100 dark:hover:bg-dark-hover">
                        <svg x-show="!darkMode" class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>
                </div>
                
                <div class="mb-8">
                    <img src="{{ asset('assets/bimasadalogo.png') }}" alt="Bimasada Logo" class="h-12 w-auto dark:brightness-0 dark:invert transition-all duration-300">
                </div>
                
                <div class="mb-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-secondary-900 dark:text-white leading-tight mb-3">Selamat Datang! 👋</h1>
                    <p class="text-secondary-500 dark:text-secondary-400 text-base">Masuk ke Sistem Invoice Management Bimasada</p>
                </div>
                
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-success-light dark:bg-success/20 border border-success/20">
                        <p class="text-sm text-success-dark dark:text-success">{{ session('status') }}</p>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@bimasada.com" required autofocus autocomplete="username" class="input-animated w-full pl-12 pr-4 py-4 bg-white dark:bg-dark-card border-2 border-secondary-200 dark:border-dark-border rounded-xl text-secondary-900 dark:text-white placeholder:text-secondary-400 dark:placeholder:text-secondary-500 focus:border-primary dark:focus:border-primary-400 focus:ring-2 focus:ring-primary/20 dark:focus:ring-primary-400/20 focus:outline-none transition-all duration-300" />
                        </div>
                        @error('email')
                            <p class="text-sm text-danger flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-secondary-700 dark:text-secondary-300">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" placeholder="Masukkan password" required autocomplete="current-password" class="input-animated w-full pl-12 pr-12 py-4 bg-white dark:bg-dark-card border-2 border-secondary-200 dark:border-dark-border rounded-xl text-secondary-900 dark:text-white placeholder:text-secondary-400 dark:placeholder:text-secondary-500 focus:border-primary dark:focus:border-primary-400 focus:ring-2 focus:ring-primary/20 dark:focus:ring-primary-400/20 focus:outline-none transition-all duration-300" />
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-secondary-400 hover:text-secondary-600 dark:hover:text-secondary-300 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-danger flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-secondary-300 dark:border-dark-border text-primary focus:ring-primary dark:bg-dark-card">
                            <span class="text-sm text-secondary-600 dark:text-secondary-400">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:text-primary-dark dark:text-primary-400 dark:hover:text-primary-300 transition-colors">Lupa password?</a>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn-glow w-full py-4 bg-primary-dark hover:bg-primary-900 dark:bg-primary dark:hover:bg-primary-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary-dark/50 dark:focus:ring-primary/50">
                        <span class="flex items-center justify-center gap-2">Masuk<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg></span>
                    </button>
                </form>
                
                <p class="mt-8 text-center text-sm text-secondary-500 dark:text-secondary-400">© {{ date('Y') }} PT Bimasada Geotekindo. All rights reserved.</p>
            </div>
        </div>
        
        <div class="hidden lg:flex lg:flex-1 animated-gradient relative items-center justify-center overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="float-1 absolute top-20 left-20 w-20 h-20 bg-white/10 rounded-2xl rotate-12"></div>
                <div class="float-2 absolute top-40 right-32 w-16 h-16 bg-white/10 rounded-full"></div>
                <div class="float-1 absolute bottom-32 left-40 w-24 h-24 bg-white/10 rounded-3xl -rotate-12"></div>
                <div class="float-2 absolute bottom-20 right-20 w-12 h-12 bg-white/10 rounded-xl rotate-45"></div>
            </div>
            <div class="relative z-10 text-center px-12 max-w-xl">
                <div class="mb-8"><img src="{{ asset('assets/loginimage.png') }}" alt="Warehouse Illustration" class="w-full max-w-md mx-auto drop-shadow-2xl"></div>
                <h2 class="text-3xl font-bold text-white mb-4">Sistem Invoice Management</h2>
                <p class="text-white/80 text-lg leading-relaxed">Kelola invoice perusahaan dengan mudah, cepat, dan efisien.</p>
                <div class="flex flex-wrap justify-center gap-3 mt-8">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">📄 Manajemen Invoice</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">👥 Data Pelanggan</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">🚗 Data Kendaraan</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>