<div class="w-full h-full grid place-items-center">

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
            <span class="text-md text-white uppercase w-full flex items-center justify-center mt-4 bg-white">{!! $person->get_bar_code('black') !!}</span>
        </div>

    </div>

    <div class="flex items-center justify-center mb-8 md:mb-16" id="virtual_card_div">
        <div class="relative">
            {{-- bar code --}}
            @if($setup['bar_code_position'] == 'top')
                <span class="font-bold text-md text-white uppercase w-full flex items-center justify-center bg-white">{!! $person->get_bar_code('black', 30) !!}</span>
            @endif
            {{-- template --}}
            <img src="{{ \App\Utils\CommonUtils::getImage($event->virtual_card_path) }}" alt="Template Card" class="static" width="300px">
            {{--<img src="{{ asset('assets/img/virtual_card_template.png') }}" alt="Template Card" class="static" width="300px">--}}
            <div class="absolute top-0 left-0 w-full">
                {{-- person names --}}
                <span class="absolute text-center font-bold text-xs uppercase w-full" style="color: {{ $setup['text_color'] ?? '#000' }} ;margin-top: {{ $setup['person_names_margin_top'] ?? 400 }}px; margin-left: {{ $setup['person_names_margin_x'] ?? 10 }}px; margin-right: {{ $setup['person_names_margin_x'] ?? 10 }}px;">{{ $person->get_short_full_name() }}</span>
                {{-- nip --}}
                <span class="absolute pt-0.5 text-center font-bold text-sm uppercase w-full" style="color: {{ $setup['text_color'] ?? '#000' }} ;margin-top: {{ $setup['dni_margin_top'] ?? 400 }}px; margin-left: {{ $setup['dni_margin_x'] ?? 10 }}px; margin-right: {{ $setup['dni_margin_x'] ?? 10 }}px;">{{ $person->nuip }}</span>
                {{-- participation modality --}}
                <span class="absolute text-center font-bold text-md text-white uppercase w-full" style="color: {{ $setup['attendance_type_text_color'] ?? '#000' }} ;margin-top: {{ $setup['attendance_type_margin_top'] ?? 400 }}px; margin-left: {{ $setup['attendance_type_margin_x'] ?? 10 }}px; margin-right: {{ $setup['attendance_type_margin_x'] ?? 10 }}px;">{{ $participation_modality }}</span>
                {{-- custom bar code position --}}
                @if($setup['bar_code_position'] == 'custom')
                    <span class="font-bold text-md text-white uppercase w-full flex items-center justify-center bg-white" style="margin-top: {{ $setup['bar_code_margin_top'] ?? 400 }}px; margin-bottom: {{ $setup['bar_code_margin_bottom'] ?? 400 }}px;margin-left: {{ $setup['bar_code_margin_left'] ?? 400 }}px;margin-right: {{ $setup['bar_code_margin_right'] ?? 400 }}px;">{!! $person->get_bar_code('black', 30) !!}</span>
                @endif
            </div>
            {{-- bar code --}}
            @if($setup['bar_code_position'] == 'bottom')
                <span class="font-bold text-md text-white uppercase w-full flex items-center justify-center bg-white">{!! $person->get_bar_code('black', 30) !!}</span>
            @endif
        </div>
    </div>

</div>
