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
    <div class="h-16 flex items-center px-4 border-b border-secondary-100 dark:border-dark-border flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 flex-1 min-w-0">
            <!-- Full Logo (when sidebar open) -->
            <template x-if="sidebarOpen">
                <img 
                    src="{{ asset('assets/bimasadalogo.png') }}" 
                    alt="Bimasada" 
                    class="h-8 w-auto dark:brightness-0 dark:invert"
                >
            </template>
            <!-- Icon Logo (when sidebar collapsed) -->
            <template x-if="!sidebarOpen">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center mx-auto">
                    <span class="text-white font-bold text-lg">B</span>
                </div>
            </template>
        </a>
        
        <!-- Collapse Button (Desktop) -->
        <button 
            @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-500 dark:text-secondary-400 transition-colors flex-shrink-0"
            x-show="sidebarOpen"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
        
        <!-- Close Button (Mobile) -->
        <button 
            @click="sidebarMobile = false"
            class="lg:hidden flex items-center justify-center w-8 h-8 rounded-lg hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-500 dark:text-secondary-400 transition-colors flex-shrink-0"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <!-- Expand Button (when collapsed - Desktop only) -->
    <button 
        @click="sidebarOpen = true"
        x-show="!sidebarOpen"
        class="hidden lg:flex items-center justify-center w-full py-3 hover:bg-secondary-100 dark:hover:bg-dark-hover text-secondary-500 dark:text-secondary-400 transition-colors border-b border-secondary-100 dark:border-dark-border"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
        </svg>
    </button>
    
    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 scrollbar-thin">
        
        <!-- Main Menu -->
        <div class="px-3 mb-6">
            <p 
                class="px-3 mb-2 text-xs font-semibold text-secondary-400 dark:text-secondary-500 uppercase tracking-wider" 
                x-show="sidebarOpen" 
                x-transition
            >
                Menu Utama
            </p>
            
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li class="relative">
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Dashboard</span>
                    </a>
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Dashboard
                    </div>
                </li>
                
                <!-- Surat Perjanjian (PKS) Management (with submenu) -->
                <li class="relative" x-data="{ open: {{ request()->routeIs('surat-perjanjians.*') ? 'true' : 'false' }} }">
                    <button 
                        @click="sidebarOpen ? open = !open : (sidebarOpen = true, open = true)"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 w-full {{ request()->routeIs('surat-perjanjians.*') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="flex-1 text-left truncate">Surat Perjanjian</span>
                        <svg 
                            x-show="sidebarOpen" 
                            x-transition.opacity
                            class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Surat Perjanjian
                    </div>
                    
                    <!-- Submenu -->
                    <div 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        x-cloak
                    >
                        <ul class="mt-1 ml-4 pl-3 border-l-2 border-secondary-200 dark:border-dark-border space-y-1">
                            <li>
                                <a 
                                    href="{{ route('surat-perjanjians.index') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('surat-perjanjians.index') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span>Daftar PKS</span>
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="{{ route('surat-perjanjians.create') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('surat-perjanjians.create') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>Buat PKS Baru</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Invoice Management (with submenu) -->
                <li class="relative" x-data="{ open: {{ request()->routeIs('invoices.*') ? 'true' : 'false' }} }">
                    <button 
                        @click="sidebarOpen ? open = !open : (sidebarOpen = true, open = true)"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 w-full {{ request()->routeIs('invoices.*') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="flex-1 text-left truncate">Invoice</span>
                        <svg 
                            x-show="sidebarOpen" 
                            x-transition.opacity
                            class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Invoice
                    </div>
                    
                    <!-- Submenu -->
                    <div 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        x-cloak
                    >
                        <ul class="mt-1 ml-4 pl-3 border-l-2 border-secondary-200 dark:border-dark-border space-y-1">
                            <li>
                                <a 
                                    href="{{ route('invoices.index') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('invoices.index') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span>Daftar Invoice</span>
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="{{ route('invoices.create') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('invoices.create') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>Input Invoice</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Kuitansi Management (with submenu) -->
                <li class="relative" x-data="{ open: {{ request()->routeIs('kuitansis.*') ? 'true' : 'false' }} }">
                    <button 
                        @click="sidebarOpen ? open = !open : (sidebarOpen = true, open = true)"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 w-full {{ request()->routeIs('kuitansis.*') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="flex-1 text-left truncate">Kuitansi</span>
                        <svg 
                            x-show="sidebarOpen" 
                            x-transition.opacity
                            class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Kuitansi
                    </div>
                    
                    <!-- Submenu -->
                    <div 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        x-cloak
                    >
                        <ul class="mt-1 ml-4 pl-3 border-l-2 border-secondary-200 dark:border-dark-border space-y-1">
                            <li>
                                <a 
                                    href="{{ route('kuitansis.index') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('kuitansis.index') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span>Daftar Kuitansi</span>
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="{{ route('kuitansis.create') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('kuitansis.create') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>Buat Kuitansi Baru</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Document Archive -->
                <li class="relative" x-data="{ open: {{ request()->routeIs('archive.*') ? 'true' : 'false' }} }">
                    <button 
                        @click="sidebarOpen ? open = !open : (sidebarOpen = true, open = true)"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 w-full {{ request()->routeIs('archive.*') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="flex-1 text-left truncate">Arsip Dokumen</span>
                        <svg 
                            x-show="sidebarOpen" 
                            x-transition.opacity
                            class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Arsip Dokumen
                    </div>
                    
                    <!-- Submenu -->
                    <div 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        x-cloak
                    >
                        <ul class="mt-1 ml-4 pl-3 border-l-2 border-secondary-200 dark:border-dark-border space-y-1">
                            <li>
                                <a 
                                    href="{{ route('archive.index') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('archive.index') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span>Semua Dokumen</span>
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="{{ route('archive.relations') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('archive.relations') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <span>Relasi Dokumen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Customers -->
                <li class="relative">
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Pelanggan</span>
                    </a>
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Pelanggan
                    </div>
                </li>
                
                <!-- Vehicles -->
                <li class="relative">
                    <a 
                        href="#" 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Kendaraan</span>
                    </a>
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Kendaraan
                    </div>
                </li>
                
                <!-- Users -->
                <li class="relative">
                    <a 
                        href="{{ route('users.index') }}" 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-primary-50 text-primary font-semibold dark:bg-primary-900/30 dark:text-primary-400' : '' }}"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="truncate">Users</span>
                    </a>
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Users
                    </div>
                </li>
            </ul>
        </div>
        
        <!-- Settings Menu -->
        <div class="px-3">
            <p 
                class="px-3 mb-2 text-xs font-semibold text-secondary-400 dark:text-secondary-500 uppercase tracking-wider" 
                x-show="sidebarOpen" 
                x-transition
            >
                Pengaturan
            </p>
            
            <ul class="space-y-1">
                <!-- Settings (with submenu) -->
                <li class="relative" x-data="{ open: false }">
                    <button 
                        @click="sidebarOpen ? open = !open : (sidebarOpen = true, open = true)"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-secondary-600 font-medium hover:bg-primary-50 hover:text-primary dark:text-secondary-300 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200 w-full"
                        :class="{ 'justify-center': !sidebarOpen }"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="flex-1 text-left truncate">Pengaturan</span>
                        <svg 
                            x-show="sidebarOpen" 
                            x-transition.opacity
                            class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                            :class="{ 'rotate-180': open }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Tooltip -->
                    <div 
                        x-show="!sidebarOpen" 
                        x-transition.opacity
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 px-2 py-1 bg-secondary-900 dark:bg-secondary-700 text-white text-sm rounded-lg opacity-0 hover:opacity-100 pointer-events-none whitespace-nowrap z-[60] hidden lg:block"
                    >
                        Pengaturan
                    </div>
                    
                    <!-- Submenu -->
                    <div 
                        x-show="open && sidebarOpen" 
                        x-collapse
                        x-cloak
                    >
                        <ul class="mt-1 ml-4 pl-3 border-l-2 border-secondary-200 dark:border-dark-border space-y-1">
                            <li>
                                <a 
                                    href="{{ route('profile.edit') }}" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Profil</span>
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="#" 
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-secondary-600 hover:bg-primary-50 hover:text-primary dark:text-secondary-400 dark:hover:bg-dark-hover dark:hover:text-primary-400 transition-all duration-200"
                                >
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>Ubah Password</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        
    </nav>
    
    <!-- User Section (Bottom) -->
    <div class="border-t border-secondary-100 dark:border-dark-border p-3 flex-shrink-0">
        <div 
            class="flex items-center gap-3 p-2 rounded-xl hover:bg-secondary-50 dark:hover:bg-dark-hover transition-colors"
            :class="{ 'justify-center': !sidebarOpen }"
        >
            <!-- Avatar -->
            <div class="w-10 h-10 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center flex-shrink-0">
                <span class="text-primary font-semibold">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </span>
            </div>
            
            <!-- User Info -->
            <div x-show="sidebarOpen" x-transition.opacity class="flex-1 min-w-0">
                <p class="text-sm font-medium text-secondary-900 dark:text-white truncate">
                    {{ Auth::user()->name ?? 'User' }}
                </p>
                <p class="text-xs text-secondary-500 dark:text-secondary-400 truncate">
                    {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                </p>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen" x-transition.opacity class="flex-shrink-0">
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
