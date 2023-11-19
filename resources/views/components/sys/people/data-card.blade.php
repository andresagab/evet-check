{{-- props of component --}}
@props([
    'person',
    'include_photo' => true,
])

{{-- php --}}
@php
    # get state values reference for current user
    $userState = $person->user->getState();
    # get role of user
    $role = $person->user->getRole();
@endphp

{{-- template --}}
<x-cards.card title="{{ __('messages.models.person.model_name') }}" :footer="0" color="gray-100">
    {{-- content card --}}
    <x-slot:content>
        {{-- user info --}}
        <div class="flex flex-col md:flex-row items-center justify-center space-y-0 md:space-x-4 w-full">

            {{-- photo --}}
            @if($include_photo)
                <img src="{{ $person->user->getProfilePhoto() }}" class="w-24 h-24 rounded-md shadow bg-white bg-auto object-contain self-center select-none">
            @endif

            {{-- data --}}
            <div class="flex flex-wrap items-baseline text-xs space-y-1">

                {{-- id --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->id }}</span>
                </div>

                {{-- full name --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.person.names_surnames') }}:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->getFullName() }}</span>
                </div>

                {{-- nuip --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.person.nip') }}:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->nuip }}</span>
                </div>

                {{-- sex --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.person.sex') }}:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->getSex() }}</span>
                </div>

                {{-- cel --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.person.cel') }}:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->cel ?? __('messages.data.unregistered') }}</span>
                </div>

                {{-- phone --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.person.phone') }}:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->phone ?? __('messages.data.unregistered') }}</span>
                </div>

                {{-- email --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">{{ __('messages.models.person.email') }}:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $person->email ?? __('messages.data.unregistered') }}</span>
                </div>

                {{-- created_at --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha de registro:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($person->created_at)->format('Y-m-d h:i a') }}</span>
                </div>

                {{-- updated_at --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Ultima actualización:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($person->updated_at)->format('Y-m-d h:i a') }}</span>
                </div>

            </div>

        </div>
    </x-slot:content>
</x-cards.card>
