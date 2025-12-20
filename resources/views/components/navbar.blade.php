@props([
    'items' => [],
])

<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-[51px] mx-auto">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-2xl font-bold text-[#02245B] font-poppins">Bimasada</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                @foreach($items as $item)
                    <a 
                        href="{{ $item['url'] }}" 
                        class="text-base font-medium font-poppins {{ request()->is($item['active'] ?? '') ? 'text-[#2387C0] border-b-2 border-[#2387C0]' : 'text-[#02245B] hover:text-[#2387C0]' }} transition-colors duration-200"
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm text-[#858788] font-poppins">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <x-button variant="outline" size="sm" type="submit">
                            Logout
                        </x-button>
                    </form>
                @else
                    <x-button variant="primary" size="sm" href="{{ route('login') }}">
                        Login
                    </x-button>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-[#02245B] hover:text-[#2387C0] focus:outline-none"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div 
        x-show="mobileMenuOpen"
        x-data="{ mobileMenuOpen: false }"
        class="md:hidden bg-white border-t border-gray-200"
        style="display: none;"
    >
        <div class="px-4 py-3 space-y-3">
            @foreach($items as $item)
                <a 
                    href="{{ $item['url'] }}" 
                    class="block text-base font-medium font-poppins {{ request()->is($item['active'] ?? '') ? 'text-[#2387C0]' : 'text-[#02245B]' }} hover:text-[#2387C0] transition-colors duration-200"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
