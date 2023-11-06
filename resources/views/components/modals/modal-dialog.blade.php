@props(['id' => null, 'maxWidth' => null, 'includeFooter' => true])

<x-modals.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">

        {{-- head section --}}
        <div class="text-lg font-medium text-gray-900">
            {{ $title }}
        </div>

        {{-- content section --}}
        <div class="mt-4 text-sm text-gray-600">
            {{ $content }}
        </div>
    </div>

    {{-- if includeFooter is true --}}
    @if($includeFooter)
        {{-- footer section --}}
        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
            {{ $footer }}
        </div>
    @endif
</x-modals.modal>
