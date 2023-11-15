{{-- props of component --}}
@props([
    'user',
    'include_photo' => true,
])

{{-- php --}}
@php
    # get state values reference for current user
    $userState = $user->getState();
    # get role of user
    $role = $user->getRole();
@endphp

{{-- template --}}
<x-cards.card title="{{ __('messages.models.user.model_name') }}" :footer="0" color="gray-100">
    {{-- content card --}}
    <x-slot:content>
        {{-- user info --}}
        <div class="flex flex-col md:flex-row items-center justify-center space-y-0 md:space-x-4 w-full">

            {{-- photo --}}
            @if($include_photo)
                <img src="{{ $user->getProfilePhoto() }}" class="w-24 h-24 rounded-md shadow bg-white bg-auto object-contain self-center select-none">
            @endif

            {{-- data --}}
            <div class="flex flex-wrap items-baseline text-xs space-y-1">

                {{-- id --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">ID:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $user->id }}</span>
                </div>

                {{-- name --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Nombre:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $user->name }}</span>
                </div>

                {{-- code --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Código:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ $user->code }}</span>
                </div>

                {{-- state --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Estado:</span>
                    <span class="font-normal text-{{ $userState['color'] }}-700 dark:text-{{ $userState['color'] }}-500 text-sm">{{ app()->getLocale() == 'es' ? $userState['es_name'] : $userState['en_name'] }}</span>
                </div>

                {{-- role --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Rol:</span>
                    <span class="font-normal text-gray-700 dark:text-slate-300 text-sm">{{ $role ? $role->display_name : __('messages.data.unregistered') }}</span>
                </div>

                {{-- created_at --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Fecha de registro:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($user->created_at)->format('Y-m-d h:i a') }}</span>
                </div>

                {{-- updated_at --}}
                <div class="inline-flex items-center space-x-1 px-1.5">
                    <span class="font-semibold text-zinc-900 dark:text-stone-100 text-sm">Ultima actualización:</span>
                    <span class="font-normal text-zinc-700 dark:text-stone-300 text-sm">{{ \Illuminate\Support\Carbon::createFromTimeString($user->updated_at)->format('Y-m-d h:i a') }}</span>
                </div>

            </div>

        </div>
    </x-slot:content>
</x-cards.card>
