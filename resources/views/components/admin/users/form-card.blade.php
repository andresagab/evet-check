{{-- props of component --}}
@props([
    'user',
    'action' => 'add',
    'profile_photo' => null,
])

{{-- template --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline w-full">

    {{-- name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Nombre:" for="frm.name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.name" required maxLength="250" placeholder="Ingresa el nombre del usuario"/>
        {{-- error --}}
        <x-forms.error for="frm.name"/>
    </x-forms.input-group>
    {{-- code --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Código:" for="frm.code" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model="frm.code" required maxLength="250" placeholder="Ingresa el código del usuario"/>
        {{-- error --}}
        <x-forms.error for="frm.code"/>
    </x-forms.input-group>
    {{-- state --}}
    @if($user->id && $action == 'edit')
        <x-forms.input-group class="w-full">
            {{-- label --}}
            <x-forms.label value="Estado:" for="frm.state" class="required"/>
            {{-- input --}}
            <x-forms.select wire:model="frm.state" required :data="\App\Models\User::STATES" special_key_content="{{ app()->getLocale() === 'es' ? 'es_name' : 'en_name' }}"/>
            {{-- error --}}
            <x-forms.error for="frm.state"/>
        </x-forms.input-group>
    @endif
    {{-- role_name --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Rol:" for="frm.role_name" class="required"/>
        {{-- input --}}
        <x-forms.select wire:model="frm.role_name" required>

            {{-- loop generate option list of roles --}}
            @foreach(\App\Models\Role::all() as $item)
                <x-forms.option value="{{ $item->name }}" class="text-gray-700 dark:text-stone-400 font-normal">{{ $item->display_name }}</x-forms.option>
            @endforeach

        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="frm.role_name"/>
    </x-forms.input-group>
    {{-- password --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Contraseña:" for="frm.password" class="{{ $action === 'add' ? 'required' : null }}"/>
        {{-- input --}}
        <x-forms.input type="password" wire:model="frm.password" :required_state="!$user->id && $action === 'add'" maxLength="250" placeholder="Ingresa la contraseña para este usuario"/>
        {{-- error --}}
        <x-forms.error for="frm.password"/>
    </x-forms.input-group>
    {{-- password_confirmation --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Confirmar contraseña:" for="frm.password_confirmation" class="{{ $action === 'add' ? 'required' : null }}"/>
        {{-- input --}}
        <x-forms.input type="password" wire:model="frm.password_confirmation" :required_state="!$user->id && $action === 'add'" maxLength="250" placeholder="Confirma la contraseña para este usuario"/>
        {{-- error --}}
        <x-forms.error for="frm.password_confirmation"/>
    </x-forms.input-group>
    {{-- profile_photo --}}
    {{--<x-forms.input-group class="w-full">
        --}}{{-- label --}}{{--
        <x-forms.label value="Foto de perfil:" for="profile_photo"/>
        --}}{{-- input --}}{{--
        <x-forms.input type="file" wire:model="profile_photo" :required_state="0" accept="image/*"/>
        --}}{{-- error --}}{{--
        <x-forms.error for="profile_photo"/>
    </x-forms.input-group>--}}

    {{ $profile_photo_slot ?? null }}

</div>
