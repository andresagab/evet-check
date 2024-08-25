<div class="w-full relative">

    {{-- search-list --}}
    <x-utils.search-list :label_name="$label_name" filter_placeholder="{{ __('messages.models.person.filters.main_searcher') }}" :text_size="$text_size" :filters="$filters" :model="$model" :searched_data="$searched_data" :custom_list="$custom_list">

        @foreach($searched_data as $item)
            <li class="flex flex-col items-start justify-start w-full space-y-0 cursor-pointer py-1 px-2 hover:bg-gray-300 dark:hover:bg-slate-700 focus:bg-gray-300 dark:focus:bg-slate-700 font-semibold dark:text-white {{ $text_size }}"
                wire:keyup.enter="select_model({{ $item }})"
                wire:click="select_model({{ $item }})"
                tabindex="-1">
                <span class="w-full">{{ $item->getFullName() }}</span>
                <span class="font-normal text-gray-700 dark:text-slate-300 text-xs">{{ $item->nuip }}</span>
                <span class="font-normal italic text-gray-700 dark:text-slate-300 text-xs">#{{ $item->id }}</span>
            </li>
        @endforeach

    </x-utils.search-list>

</div>
