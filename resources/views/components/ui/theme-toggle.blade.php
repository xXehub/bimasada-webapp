@props([
    'darkMode' => false,
])

<!-- Theme Toggle Button -->
<button
    type="button"
    x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            document.documentElement.classList.toggle('dark', this.darkMode);
        }
    }"
    x-init="document.documentElement.classList.toggle('dark', darkMode)"
    @click="toggle()"
    {{ $attributes->merge(['class' => 'relative inline-flex items-center justify-center p-2.5 rounded-xl transition-all duration-200 hover:bg-secondary-100 dark:hover:bg-dark-hover focus:outline-none focus:ring-2 focus:ring-primary/50']) }}
    aria-label="Toggle dark mode"
>
    <!-- Sun Icon (Light Mode) -->
    <svg 
        x-show="!darkMode" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 rotate-90 scale-0"
        x-transition:enter-end="opacity-100 rotate-0 scale-100"
        class="w-5 h-5 text-warning" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    
    <!-- Moon Icon (Dark Mode) -->
    <svg 
        x-show="darkMode" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -rotate-90 scale-0"
        x-transition:enter-end="opacity-100 rotate-0 scale-100"
        class="w-5 h-5 text-primary-400" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
</button>
