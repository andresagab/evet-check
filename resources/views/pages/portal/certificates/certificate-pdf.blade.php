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

        .container {
            font-family: arial;
            font-size: 24px;
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
            width: 100%;
            text-align: center;
            position: absolute;
        }

    </style>

</head>
<body>

    <div class="container">
        <div class="child">
            <h3>El Programa de Licenciatura en Informática y la Maestría en TIC Aplicadas a la Educación de la Universidad de Nariño</h3>
            <h3>Certifican que:</h3>
            <h3>{{ mb_strtoupper($person->getFullName(), 'UTF-8') }}</h3>
            <div>
                <span>D.I.:</span>
                <span>{{ $person->nuip }}</span>
            </div>
            <p>
                Participó como <b>{{ __($event_attendance->get_participation_modality('key_name')) }}</b> los días XX, XX y XX de XXXX del {{ $event->year }} en el <b><i>{{ $event->name }}</i></b>
            </p>
        </div>
    </div>

</body>
</html>
