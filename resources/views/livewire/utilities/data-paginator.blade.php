{{-- pagination --}}
<div class="flex flex-col items-center justify-center space-y-2 bg-white dark:bg-slate-700 rounded-md shadow-md shadow-zin-500/60 hover:shadow-lg px-4 py-6 transition-all ease-in-out duration-300">
    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading wire:target="managePage"/>
    {{-- navigation --}}
    <div class="flex flex-row items-end justify-center space-x-2">
        {{-- if current page is greater than 1 --}}
        @if($pagination['page'] > 1)
            {{-- previous page --}}
            <div class="inline-flex items-center">
                <span class="font-semibold text-xs text-gray-900 dark:text-white">Página anterior: {{ $pagination['page'] - 1 }}</span>
            </div>
            {{-- previous page button --}}
            <x-buttons.circle-icon-button wire:click="managePage(-1)" type="button" color="blue" iconSize="22px">navigate_before</x-buttons.circle-icon-button>
        @endif
        {{-- current page --}}
        <div class="flex flex-col items-center space-y-1">
            <label class="font-normal text-xs text-gray-900 dark:text-white">Página actual:</label>
            <input type="number" wire:model.defer="pagination.page" wire:keydown.enter="managePage(0, true)" placeholder="N° de página" min="1" max="{{ $pagination['total_pages'] }}" class="font-normal text-sm px-2 py-1 bg-gray-200 dark:bg-slate-900 dark:text-stone-200 border-none rounded-md w-24">
        </div>
        {{-- if current page is less than total pages --}}
        @if($pagination['page'] < $pagination['total_pages'])
            {{-- next page button --}}
            <x-buttons.circle-icon-button wire:click="managePage(1)" type="button" color="blue" iconSize="22px">navigate_next</x-buttons.circle-icon-button>
            {{-- next page preview --}}
            <div class="inline-flex items-center">
                <span class="font-semibold text-xs text-gray-900 dark:text-white">Página siguiente: {{ $pagination['page'] + 1 }}</span>
            </div>
        @endif
    </div>
    {{-- info records --}}
    <div class="inline-flex items-center">
        <span class="font-normal text-xs text-gray-800 dark:text-stone-200">Mostrando {{ $pagination['per_page'] }} registros de {{ $pagination['total_records'] }}</span>
    </div>
    {{-- info pages --}}
    <div class="inline-flex items-center">
        <span class="font-normal text-xs text-gray-800 dark:text-stone-200">Página {{ $pagination['page'] }} de {{ ceil($pagination['total_pages']) }}</span>
    </div>
</div>
