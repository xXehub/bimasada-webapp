@props([
    'count' => 3,
])

<div class="space-y-4">
    @for($i = 0; $i < $count; $i++)
        <x-ui.card class="animate-pulse">
            <div class="flex items-start gap-4">
                <x-ui.skeleton height="h-12" width="w-12" rounded="rounded-xl" />
                <div class="flex-1 space-y-3">
                    <x-ui.skeleton height="h-4" width="w-3/4" />
                    <x-ui.skeleton height="h-3" width="w-1/2" />
                    <div class="flex gap-2 pt-2">
                        <x-ui.skeleton height="h-6" width="w-16" rounded="rounded-full" />
                        <x-ui.skeleton height="h-6" width="w-20" rounded="rounded-full" />
                    </div>
                </div>
            </div>
        </x-ui.card>
    @endfor
</div>
