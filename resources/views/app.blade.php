<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('fontawesome-5/css/all.min.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('css/timepicker/mdtimepicker.css') }}">
        
        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        
        @inertia

        @env ('local')
            <!--<script src="http://localhost:8080/js/bundle.js"></script>-->
        @endenv
        <script src="{{asset('/js/jQuery-3.6.js')}}"></script>
        <script src="{{asset('/js/timepicker/mdtimepicker.js')}}"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY','AIzaSyDSK0fk1H6lqwXJQo9fjIN-3T-Y6_LhKEQ')}}&libraries=maps,places,geometry"></script>
        <div id="location" class="d-none"></div>
    </body>
</html>
