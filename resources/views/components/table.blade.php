@props([
    'headers' => [],
    'sortable' => false,
])

<div class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'w-full table-auto']) }}>
            @isset($header)
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        {{ $header }}
                    </tr>
                </thead>
            @endisset
            
            @isset($body)
                <tbody class="divide-y divide-gray-200">
                    {{ $body }}
                </tbody>
            @endisset
        </table>
    </div>
    
    @isset($footer)
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endisset
</div>

<style>
    /* Table Header Styling */
    thead th {
        @apply px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider font-poppins;
    }
    
    /* Table Row Styling */
    tbody tr {
        @apply hover:bg-gray-50 transition-colors duration-150;
    }
    
    tbody td {
        @apply px-4 py-4 text-sm text-[#02245B] font-poppins;
    }
    
    /* Sortable column indicator */
    .sortable {
        @apply cursor-pointer select-none hover:text-[#2387C0];
    }
    
    .sortable::after {
        content: ' ↑↓';
        opacity: 0.5;
    }
</style>
