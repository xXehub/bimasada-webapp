<!-- Sidebar Component -->
<aside 
    class="fixed left-0 top-0 h-full bg-white dark:bg-dark-sidebar border-r border-secondary-100 dark:border-dark-border z-50 transition-all duration-300 flex flex-col shadow-sidebar"
    :class="{
        'w-[280px]': sidebarOpen,
        'w-[80px]': !sidebarOpen,
        '-translate-x-full lg:translate-x-0': !sidebarMobile,
        'translate-x-0': sidebarMobile
    }"
>
    
    <!-- Logo Section -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-secondary-100 dark:border-dark-border flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <img 
                src="{{ asset('assets/bimasadalogo.png') }}" 
                alt="Bimasada" 
                class="h-8 w-auto dark:brightness-0 dark:invert"
                :class="{ 'hidden': !sidebarOpen }"
            >
            <img 
                src="{{ asset('assets/bimasadalogo.png') }}" 
                alt="Bimasada" 
                class="h-8 w-8 object-contain dark:brightness-0 dark:invert"
                :class="{ 'hidden': sidebarOpen }"
            >
        </a>
        
        <!-- Collapse Button (Desktop) -->
        <button 
            @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-500 dark:text-secondary-400 transition-colors"
            :class="{ 'rotate-180': !sidebarOpen }"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
        
        <!-- Close Button (Mobile) -->
        <button 
            @click="sidebarMobile = false"
            class="lg:hidden flex items-center justify-center w-8 h-8 rounded-lg hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-500 dark:text-secondary-400 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 scrollbar-thin">
        
        <!-- Main Menu -->
        <div class="px-3 mb-6">
            <p class="px-4 mb-2 text-xs font-semibold text-secondary-400 dark:text-secondary-500 uppercase tracking-wider" x-show="sidebarOpen" x-transition>
                Menu Utama
            </p>
            
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="sidebar-item group"
                        :class="{ 
                            'sidebar-item-active': '{{ request()->routeIs('dashboard') }}',
                            'justify-center': !sidebarOpen
                        }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
                        
                        <!-- Tooltip for collapsed state -->
                        <div 
                            x-show="!sidebarOpen" 
                            class="absolute left-full ml-2 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50"
                        >
                            Dashboard
                        </div>
                    </a>
                </li>
                
                <!-- Invoice Management (with submenu) -->
                <li x-data="{ open: {{ request()->routeIs('invoices.*') ? 'true' : 'false' }} }">
                    <button 
                        @click="open = !open"
                        class="sidebar-item w-full group"
                        :class="{ 
                            'sidebar-item-active': '{{ request()->routeIs('invoices.*') }}',
                            'justify-center': !sidebarOpen
                        }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="flex-1 text-left truncate">Invoice</span>
                        <svg 
                            x-show="sidebarOpen" 
                            class="w-4 h-4 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        
                        <!-- Tooltip for collapsed state -->
                        <div 
                            x-show="!sidebarOpen" 
                            class="absolute left-full ml-2 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50"
                        >
                            Invoice
                        </div>
                    </button>
                    
                    <!-- Submenu -->
                    <ul 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        class="mt-1 ml-4 pl-4 border-l-2 border-secondary-200 dark:border-dark-border space-y-1"
                    >
                        <li>
                            <a 
                                href="{{ route('invoices.index') }}" 
                                class="sidebar-item text-sm"
                                :class="{ 'sidebar-item-active': '{{ request()->routeIs('invoices.index') }}' }"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span>Daftar Invoice</span>
                            </a>
                        </li>
                        <li>
                            <a 
                                href="{{ route('invoices.create') }}" 
                                class="sidebar-item text-sm"
                                :class="{ 'sidebar-item-active': '{{ request()->routeIs('invoices.create') }}' }"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Input Invoice</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Customers -->
                <li>
                    <a 
                        href="#" 
                        class="sidebar-item group"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="truncate">Pelanggan</span>
                        
                        <div 
                            x-show="!sidebarOpen" 
                            class="absolute left-full ml-2 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50"
                        >
                            Pelanggan
                        </div>
                    </a>
                </li>
                
                <!-- Vehicles -->
                <li>
                    <a 
                        href="#" 
                        class="sidebar-item group"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="truncate">Kendaraan</span>
                        
                        <div 
                            x-show="!sidebarOpen" 
                            class="absolute left-full ml-2 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50"
                        >
                            Kendaraan
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Settings Menu -->
        <div class="px-3">
            <p class="px-4 mb-2 text-xs font-semibold text-secondary-400 dark:text-secondary-500 uppercase tracking-wider" x-show="sidebarOpen" x-transition>
                Pengaturan
            </p>
            
            <ul class="space-y-1">
                <!-- Settings (with submenu) -->
                <li x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="sidebar-item w-full group"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="flex-1 text-left truncate">Pengaturan</span>
                        <svg 
                            x-show="sidebarOpen" 
                            class="w-4 h-4 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        
                        <div 
                            x-show="!sidebarOpen" 
                            class="absolute left-full ml-2 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50"
                        >
                            Pengaturan
                        </div>
                    </button>
                    
                    <!-- Submenu -->
                    <ul 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        class="mt-1 ml-4 pl-4 border-l-2 border-secondary-200 dark:border-dark-border space-y-1"
                    >
                        <li>
                            <a href="{{ route('profile.edit') }}" class="sidebar-item text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Profil</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-item text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span>Ubah Password</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        
    </nav>
    
    <!-- User Section (Bottom) -->
    <div class="border-t border-secondary-100 dark:border-dark-border p-4 flex-shrink-0">
        <div 
            class="flex items-center gap-3"
            :class="{ 'justify-center': !sidebarOpen }"
        >
            <!-- Avatar -->
            <div class="w-10 h-10 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center flex-shrink-0">
                <span class="text-primary font-semibold">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </span>
            </div>
            
            <!-- User Info -->
            <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                <p class="text-sm font-medium text-secondary-900 dark:text-white truncate">
                    {{ Auth::user()->name ?? 'User' }}
                </p>
                <p class="text-xs text-secondary-500 dark:text-secondary-400 truncate">
                    {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                </p>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" x-transition>
                @csrf
                <button 
                    type="submit"
                    class="p-2 rounded-lg hover:bg-danger/10 text-secondary-400 hover:text-danger transition-colors"
                    title="Logout"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    
</aside>
