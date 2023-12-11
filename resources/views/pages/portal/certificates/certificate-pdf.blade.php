<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado | {{ $event->year }} | {{ $event->name }} | {{ $person->getFullName() }}</title>

    {{-- custom stles --}}
    <style>

        @page {
            margin: 0;
        }

        .container {
            font-family: arial;
            font-size: {{ $setup['font_size'] ?? 24 }}px;
            width: 100%;
            height: 100%;
            outline: dashed 1px black;
            /* Center vertically and horizontally */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .child {
            width: auto;
            text-align: center;
            position: absolute;
            margin-left: {{ $setup['margin_left_right'] ?? 100 }}px;
            margin-right: {{ $setup['margin_left_right'] ?? 100 }}px;
            color: {{ $setup['text_color'] ?? "#000" }};
            margin-top: {{ $setup['margin_top'] ?? 150 }}px;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            margin: 0;
            z-index: -1000;
            opacity: {{ $setup['background_opacity'] ?? .9 }};
        }

    </style>

</head>
<body>

    <div class="watermark">
        <img src="{{ public_path(\App\Utils\CommonUtils::getImage($event->certificate_path)) }}" width="100%">
    </div>

    <main>
        <div class="container">
            <div class="child">
                <h3>{{ $setup['head_text'] ?? 'Este certificado no está configurado' }}</h3>
                <div style="margin-top: {{ $setup['margin_top_middle_text'] ?? 30 }}px; margin-bottom: {{ $setup['margin_bottom_middle_text'] ?? 30 }}px;">
                    <h3>Certifican que:</h3>
                    <h3>{{ mb_strtoupper($person->getFullName(), 'UTF-8') }}</h3>
                    <span>D.I.:</span>
                    <span>{{ $person->nuip }}</span>
                </div>
                <p>
                    Participó como <b>{{ __($event_attendance->get_participation_modality('key_name')) }}</b> {{ $setup['dates_range'] }} en el <b><i>{{ $event->name }}</i></b>
                </p>
            </div>
        </div>
    </main>

</body>
</html>
