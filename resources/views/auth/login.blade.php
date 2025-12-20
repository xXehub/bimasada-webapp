<x-guest-layout>
    <div class="min-h-screen bg-white flex">
        <!-- Left Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-8 py-12">
            <div class="w-full max-w-[582px]">
                <!-- Logo -->
                <div class="mb-12">
                    <h1 class="text-[46px] font-poppins font-semibold text-[#02245B] leading-[92px]">
                        Bimasada Invoice
                    </h1>
                </div>

                <!-- Welcome Text -->
                <div class="mb-12">
                    <h2 class="text-[46px] font-poppins font-semibold text-black leading-[92px] mb-4">
                        Selamat Datang di Sistem Informasi<br>
                        Invoice Management
                    </h2>
                    <p class="text-lg font-poppins font-medium text-[#858788] leading-[44px]">
                        Silahkan masukkan nama, kode karyawan, dan password untuk masuk ke dalam akun Anda.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Name Input -->
                    <div>
                        <x-input 
                            id="name" 
                            type="text" 
                            name="name" 
                            placeholder="Masukkan Nama Anda"
                            :value="old('name')"
                            required 
                            autofocus
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Employee Code Input -->
                    <div>
                        <x-input 
                            id="email" 
                            type="email" 
                            name="email" 
                            placeholder="Masukkan Kode Karyawan Anda"
                            :value="old('email')"
                            required
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Input -->
                    <div>
                        <x-input 
                            id="password" 
                            type="password" 
                            name="password" 
                            placeholder="Masukkan Password"
                            required
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="rounded border-[#02245B] text-[#02245B] shadow-sm focus:ring-[#2387C0]" 
                                name="remember"
                            >
                            <span class="ms-2 text-sm text-[#02245B] font-poppins">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-[#2387C0] hover:text-[#1a6a99] font-poppins" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="mt-8">
                        <x-button 
                            variant="primary" 
                            type="submit" 
                            class="w-full !h-[61px] text-lg"
                        >
                            Log In
                        </x-button>
                    </div>
                </form>

                <!-- Development Credentials Info -->
                @if(config('app.env') === 'local')
                    <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm font-poppins text-[#02245B] font-semibold mb-2">Demo Credentials:</p>
                        <div class="text-xs font-poppins text-[#858788] space-y-1">
                            <p><strong>Marketing Manager:</strong> manager@bimasada.com / manager123</p>
                            <p><strong>Sales:</strong> sales@bimasada.com / sales123</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#02245B] to-[#2387C0] items-center justify-center p-12">
            <div class="text-center">
                <div class="mb-8">
                    <svg class="w-96 h-96 mx-auto text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-4xl font-poppins font-bold text-white mb-4">
                    Invoice Management System
                </h3>
                <p class="text-xl font-poppins text-white opacity-90">
                    Kelola invoice Anda dengan mudah dan efisien
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
