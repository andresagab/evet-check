{{-- props --}}
@props([
    'padding' => 'p-4'
])

{{-- template --}}
<div class="flex min-h-screen w-full items-center justify-center">
    <div class="m-auto w-full bg-gray-100 dark:bg-slate-900 rounded-md mt-8 {{ $padding }} space-y-6">

        {{ $slot }}

    </div>
</div>
