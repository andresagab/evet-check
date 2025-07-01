@props([])

{{-- php code --}}
@php
@endphp

{{-- template --}}
<footer {{ $attributes->merge([
    'class' => 'flex w-full p-8 dark:bg-slate-950 bg-gradient-to-b from-gray-900'
    ])
    }}
>
    <blockquote class="block text-center text-sm break-words text-slate-400 w-full">
        <p>
            Desarrollador en colaboración con: <a href="https://www.linkedin.com/in/andresangulodev/" target="_blank" title="Click para ver el perfil del autor principal" class="text-blue-600 dark:text-blue-400 hover:underline transition ease-in-out duration-150">Andrés Angulo - Software Developer</a>
        </p>
        <a href="https://github.com/andresagab/evet-check?tab=MIT-1-ov-file#readme" target="_blank" title="Click para ver la licencia" class="text-center text-sm break-words text-slate-300 hover:underline">MIT License - {{ date('Y') }}</a>
    </blockquote>
</footer>
