<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Bimasada') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Check for dark mode preference on page load (before render to avoid flash)
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full font-poppins bg-secondary-50 dark:bg-dark transition-colors duration-300">
    
    <div 
        x-data="{ 
            sidebarOpen: true, 
            sidebarMobile: false,
            init() {
                // Check screen size on load
                if (window.innerWidth < 1024) {
                    this.sidebarOpen = false;
                }
                // Listen for resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth < 1024) {
                        this.sidebarOpen = false;
                        this.sidebarMobile = false;
                    } else {
                        this.sidebarMobile = false;
                    }
                });
            }
        }" 
        class="min-h-screen"
    >
        
        <!-- Sidebar -->
        <x-layout.sidebar />
        
        <!-- Mobile Sidebar Overlay -->
        <div 
            x-show="sidebarMobile" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarMobile = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
            x-cloak
        ></div>
        
        <!-- Main Content Area -->
        <div 
            class="transition-all duration-300 min-h-screen"
            :class="sidebarOpen ? 'lg:ml-[280px]' : 'lg:ml-[80px]'"
        >
            
            <!-- Header -->
            <x-layout.header />
            
            <!-- Page Content -->
            <main class="pt-20 px-4 lg:px-8 pb-8">
                {{ $slot }}
            </main>
            
        </div>
        
    </div>
    
    <!-- Toast Notifications -->
    <x-ui.toast />
    
    @stack('scripts')
</body>
</html>
