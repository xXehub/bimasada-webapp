<!-- Header Component -->
<header 
    class="fixed top-0 right-0 h-16 bg-white dark:bg-dark-card border-b border-secondary-100 dark:border-dark-border z-30 transition-all duration-300 flex items-center justify-between px-4 lg:px-8"
    :class="sidebarOpen ? 'left-0 lg:left-[280px]' : 'left-0 lg:left-[80px]'"
>
    
    <!-- Left Section -->
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Toggle -->
        <button 
            @click="sidebarMobile = true"
            class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-600 dark:text-secondary-400 transition-colors"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Page Title / Breadcrumb -->
        <div>
            <h1 class="text-lg font-semibold text-secondary-900 dark:text-white">
                @yield('page-title', 'Dashboard')
            </h1>
            @hasSection('breadcrumb')
                <nav class="text-sm text-secondary-500 dark:text-secondary-400">
                    @yield('breadcrumb')
                </nav>
            @endif
        </div>
    </div>
    
    <!-- Right Section -->
    <div class="flex items-center gap-2">
        
        <!-- Search Button (Optional) -->
        <button 
            class="hidden sm:flex items-center gap-2 px-4 py-2 bg-secondary-100 dark:bg-dark-hover rounded-xl text-secondary-500 dark:text-secondary-400 hover:bg-secondary-200 dark:hover:bg-secondary-700 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="text-sm">Search...</span>
            <kbd class="hidden md:inline-flex items-center px-2 py-0.5 bg-white dark:bg-dark-card rounded text-xs font-medium text-secondary-400">
                ⌘K
            </kbd>
        </button>
        
        <!-- Theme Toggle -->
        <x-ui.theme-toggle />
        
        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open"
                class="relative flex items-center justify-center w-10 h-10 rounded-xl hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-600 dark:text-secondary-400 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <!-- Notification Badge -->
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-danger rounded-full"></span>
            </button>
            
            <!-- Dropdown -->
            <div 
                x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-80 bg-white dark:bg-dark-card rounded-xl shadow-lg border border-secondary-100 dark:border-dark-border py-2 z-50"
                x-cloak
            >
                <div class="px-4 py-2 border-b border-secondary-100 dark:border-dark-border">
                    <h3 class="font-semibold text-secondary-900 dark:text-white">Notifikasi</h3>
                </div>
                
                <div class="max-h-64 overflow-y-auto">
                    <!-- Sample Notifications -->
                    <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-secondary-50 dark:hover:bg-dark-hover transition-colors">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-900 dark:text-white">Invoice baru dibuat</p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">INV-2024-001 telah dibuat</p>
                            <p class="text-xs text-secondary-400 dark:text-secondary-500 mt-1">5 menit yang lalu</p>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-secondary-50 dark:hover:bg-dark-hover transition-colors">
                        <div class="w-8 h-8 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-900 dark:text-white">Invoice disetujui</p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">INV-2024-002 telah disetujui</p>
                            <p class="text-xs text-secondary-400 dark:text-secondary-500 mt-1">1 jam yang lalu</p>
                        </div>
                    </a>
                </div>
                
                <div class="px-4 py-2 border-t border-secondary-100 dark:border-dark-border">
                    <a href="#" class="text-sm font-medium text-primary hover:text-primary-dark dark:text-primary-400 dark:hover:text-primary-300">
                        Lihat semua notifikasi
                    </a>
                </div>
            </div>
        </div>
        
        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open"
                class="flex items-center gap-3 pl-3 pr-2 py-1.5 rounded-xl hover:bg-secondary-100 dark:hover:bg-dark-hover transition-colors"
            >
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-medium text-secondary-900 dark:text-white">
                        {{ Auth::user()->name ?? 'User' }}
                    </p>
                    <p class="text-xs text-secondary-500 dark:text-secondary-400">
                        {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                    </p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center">
                    <span class="text-primary font-semibold text-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </span>
                </div>
                <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <!-- Dropdown -->
            <div 
                x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card rounded-xl shadow-lg border border-secondary-100 dark:border-dark-border py-2 z-50"
                x-cloak
            >
                <div class="px-4 py-2 border-b border-secondary-100 dark:border-dark-border">
                    <p class="text-sm font-medium text-secondary-900 dark:text-white">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-secondary-500 dark:text-secondary-400">{{ Auth::user()->email ?? '' }}</p>
                </div>
                
                <div class="py-2">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profil Saya</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </div>
                
                <div class="border-t border-secondary-100 dark:border-dark-border pt-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item w-full text-danger hover:bg-danger/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</header>
