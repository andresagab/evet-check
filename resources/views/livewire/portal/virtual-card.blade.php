<div class="w-full h-screen grid place-items-center">

    {{-- full-page-loader --}}
    <x-loaders.full-page-loader wire:loading/>

    <div class="w-full flex flex-col p-8 md:p-16">

        {{-- page name --}}
        <h1 class="font-bold text-3xl md:text-5xl text-white text-center mt-10 md:mt-6">CARNET VIRTUAL</h1>

        {{-- event --}}
        <h2 class="font-normal text-xl md:text-3xl text-sky-100 text-center mt-8">{{ $event->name }}</h2>

        {{-- attendance info --}}
        <div class="m-auto w-full md:w-1/2 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition ease-in-out duration-300 rounded-md p-4 mt-8">
            {{-- person --}}
            <h3 class="font-semibold text-lg md:text-xl text-slate-100 text-left">{{ $person->getFullName() }}</h3>
            {{-- participation modality --}}
            <h3 class="font-normal text-md md:text-xl text-slate-300 text-left">{{ $participation_modality }}</h3>
            {{-- bar code --}}
            <span class="text-md text-white uppercase w-full flex items-center justify-center z-50 mt-4">{!! $person->get_bar_code() !!}</span>
        </div>

    </div>

    <div class="flex items-center justify-center mb-8 md:mb-16" id="virtual_card_div">
        <div class="relative">
            {{-- template --}}
            <img src="{{ asset('assets/img/virtual_card_template.png') }}" alt="Template Card" class="static" width="300px">
            <div class="absolute top-0 left-0 w-full">
                {{-- person names --}}
                <span class="absolute top-48 text-center font-bold text-xs uppercase w-full">{{ $person->get_short_full_name() }}</span>
                {{-- nip --}}
                <span class="absolute pt-0.5 top-60 text-center font-bold text-sm uppercase w-full">{{ $person->nuip }}</span>
                {{-- participation modality --}}
                <span class="absolute top-72 text-center font-bold text-md text-white uppercase w-full">{{ $participation_modality }}</span>
                {{-- bar code --}}
                <span class="absolute top-80 font-bold text-md text-white uppercase w-full flex items-center justify-center z-50 bg-stone-900 bg-opacity-50">{!! $person->get_bar_code() !!}</span>

            </div>
        </div>
    </div>

</div>
