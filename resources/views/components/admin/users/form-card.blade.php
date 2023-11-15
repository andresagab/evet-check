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
        <x-forms.label value="Nombre:" for="user.name" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model.defer="user.name" required maxLength="250" placeholder="Ingresa el nombre del usuario"/>
        {{-- error --}}
        <x-forms.error for="user.name"/>
    </x-forms.input-group>
    {{-- code --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Código:" for="user.code" class="required"/>
        {{-- input --}}
        <x-forms.input type="text" wire:model.defer="user.code" required maxLength="250" placeholder="Ingresa el código del usuario"/>
        {{-- error --}}
        <x-forms.error for="user.code"/>
    </x-forms.input-group>
    {{-- state --}}
    @if($user->id && $action == 'edit')
        <x-forms.input-group class="w-full">
            {{-- label --}}
            <x-forms.label value="Estado:" for="user.state" class="required"/>
            {{-- input --}}
            <x-forms.select wire:model.defer="user.state" required :data="\App\Models\User::STATES" special_key_content="{{ app()->getLocale() === 'es' ? 'es_name' : 'en_name' }}"/>
            {{-- error --}}
            <x-forms.error for="user.state"/>
        </x-forms.input-group>
    @endif
    {{-- role --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Rol:" for="role.name" class="required"/>
        {{-- input --}}
        <x-forms.select wire:model.defer="role.name" required>

            {{-- loop generate option list of roles --}}
            @foreach(\App\Models\Role::all() as $item)
                <x-forms.option value="{{ $item->name }}">{{ $item->display_name }}</x-forms.option>
            @endforeach

        </x-forms.select>
        {{-- error --}}
        <x-forms.error for="role.name"/>
    </x-forms.input-group>
    {{-- password --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Contraseña:" for="passwords.password" class="{{ $action === 'add' ? 'required' : null }}"/>
        {{-- input --}}
        <x-forms.input type="password" wire:model.defer="passwords.password" :required_state="!$user->id && $action === 'add'" maxLength="250" placeholder="Ingresa la contraseña para este usuario"/>
        {{-- error --}}
        <x-forms.error for="passwords.password"/>
    </x-forms.input-group>
    {{-- password_confirmation --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Confirmar contraseña:" for="passwords.password_confirmation" class="{{ $action === 'add' ? 'required' : null }}"/>
        {{-- input --}}
        <x-forms.input type="password" wire:model.defer="passwords.password_confirmation" :required_state="!$user->id && $action === 'add'" maxLength="250" placeholder="Confirma la contraseña para este usuario"/>
        {{-- error --}}
        <x-forms.error for="passwords.password_confirmation"/>
    </x-forms.input-group>
    {{-- profile_photo --}}
    <x-forms.input-group class="w-full">
        {{-- label --}}
        <x-forms.label value="Foto de perfil:" for="profile_photo"/>
        {{-- input --}}
        <x-forms.input type="file" wire:model.defer="profile_photo" :required_state="0" accept="image/*"/>
        {{-- error --}}
        <x-forms.error for="profile_photo"/>
    </x-forms.input-group>

    {{ $profile_photo_slot ?? null }}

</div>
