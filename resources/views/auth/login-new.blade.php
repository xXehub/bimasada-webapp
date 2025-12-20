<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bimasada Invoice Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }
    </style>
</head>
<body class="h-full bg-white">
    <div class="relative min-h-screen bg-white overflow-hidden">
        
        <!-- Logo Fixed Top Left (sama seperti Figma: position fixed, top 47px, left 51px) -->
        <div class="fixed top-[47px] left-[51px] z-50">
            <img src="{{ asset('assets/bimasadalogo.png') }}" alt="Bimasada Logo" class="w-[215px] h-[49px] object-contain">
        </div>

        <!-- Main Container -->
        <div class="min-h-screen flex items-center">
            <div class="w-full max-w-[1512px] mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    
                    <!-- LEFT SIDE: Form Login (exact position dari Figma) -->
                    <div class="w-full pl-[51px] pr-8">
                        <!-- Header Text (top: 156px dari Figma) -->
                        <div class="mb-8">
                            <h1 class="text-[46px] font-semibold text-black leading-[92px] mb-0" style="font-family: 'Poppins', sans-serif;">
                                Selamat Datang di Sistem Informasi<br/>Invoice Management
                            </h1>
                        </div>
                        
                        <!-- Subtitle (top: 371px dari Figma) -->
                        <div class="mb-10">
                            <p class="text-[18px] font-medium leading-[44px]" style="color: #858788; font-family: 'Poppins', sans-serif;">
                                Silahkan masukkan nama, kode karyawan, dan password untuk masuk ke dalam akun Anda.
                            </p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Input 1: Email (width: 582px, height: 61px, border-radius: 20px) -->
                            <div>
                                <div class="relative">
                                    <input 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email') }}"
                                        required 
                                        autofocus 
                                        autocomplete="username"
                                        placeholder="Masukkan Email Anda"
                                        style="
                                            width: 582px;
                                            max-width: 100%;
                                            height: 61px;
                                            padding-left: 21px;
                                            padding-right: 21px;
                                            font-size: 14px;
                                            font-weight: 500;
                                            color: #2387C0;
                                            background-color: #ffffff;
                                            border: 2px solid #2387C0;
                                            border-radius: 20px;
                                            outline: none;
                                            font-family: 'Poppins', sans-serif;
                                        "
                                        class="transition-all focus:ring-2 focus:ring-[#2387C0] focus:ring-opacity-50"
                                        onfocus="this.style.borderColor='#2387C0'"
                                    />
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600" style="font-family: 'Poppins', sans-serif;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Input 2: Password (sama styling seperti input 1) -->
                            <div>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        required 
                                        autocomplete="current-password"
                                        placeholder="Masukkan Password"
                                        style="
                                            width: 582px;
                                            max-width: 100%;
                                            height: 61px;
                                            padding-left: 21px;
                                            padding-right: 21px;
                                            font-size: 14px;
                                            font-weight: 500;
                                            color: #2387C0;
                                            background-color: #ffffff;
                                            border: 2px solid #2387C0;
                                            border-radius: 20px;
                                            outline: none;
                                            font-family: 'Poppins', sans-serif;
                                        "
                                        class="transition-all focus:ring-2 focus:ring-[#2387C0] focus:ring-opacity-50"
                                        onfocus="this.style.borderColor='#2387C0'"
                                    />
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600" style="font-family: 'Poppins', sans-serif;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me (hidden) -->
                            <input type="hidden" name="remember" value="1">

                            <!-- Login Button (width: 582px, height: 69px, bg: #2387C0) -->
                            <div class="pt-8">
                                <button 
                                    type="submit"
                                    style="
                                        width: 582px;
                                        max-width: 100%;
                                        height: 69px;
                                        background-color: #2387C0;
                                        color: #ffffff;
                                        font-size: 18px;
                                        font-weight: 700;
                                        border-radius: 20px;
                                        border: none;
                                        cursor: pointer;
                                        font-family: 'Poppins', sans-serif;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        transition: all 0.2s ease;
                                    "
                                    class="hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-[#2387C0] focus:ring-opacity-50"
                                    onmouseover="this.style.backgroundColor='#1c6a96'"
                                    onmouseout="this.style.backgroundColor='#2387C0'"
                                >
                                    Log In
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- RIGHT SIDE: Illustration Image (exact position dari Figma: top 371px, left 677px) -->
                    <div class="hidden lg:flex items-center justify-center">
                        <img 
                            src="{{ asset('assets/loginimage.png') }}" 
                            alt="Warehouse Forklift Illustration" 
                            style="
                                width: 778px;
                                height: 565px;
                                object-fit: cover;
                            "
                            class="w-full h-auto"
                        />
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
