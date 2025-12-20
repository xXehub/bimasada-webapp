@props([
    'rows' => 5,
    'cols' => 4,
])

<x-ui.table>
    <x-slot name="head">
        <tr>
            @for($i = 0; $i < $cols; $i++)
                <x-ui.table-header>
                    <x-ui.skeleton height="h-3" width="w-20" />
                </x-ui.table-header>
            @endfor
        </tr>
    </x-slot>
    
    @for($row = 0; $row < $rows; $row++)
        <tr>
            @for($col = 0; $col < $cols; $col++)
                <x-ui.table-cell>
                    <x-ui.skeleton 
                        height="h-4" 
                        :width="$col === 0 ? 'w-32' : ($col === $cols - 1 ? 'w-16' : 'w-24')" 
                    />
                </x-ui.table-cell>
            @endfor
        </tr>
    @endfor
</x-ui.table>
