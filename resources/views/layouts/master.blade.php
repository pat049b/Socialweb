<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>@yield('title')</title>
    <!-- Latest compiled and minified JavaScript -->
    <link rel="stylesheet" href="{{ URL::to('css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::to('fullcalendar/fullcalendar.min.css') }}">
    <link href="{{ URL::to('/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print' />

</head>
<body>
    @include('includes.header')
    <div class="container">
    @yield('content')
    </div>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>﻿
    <script src="{{ URL::to('src/js/app.js') }}"></script>

    <script src="{{ URL::to('fullcalendar/lib/moment.min.js') }}"></script>
    <script type='text/javascript' src="{{ URL::to('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type='text/javascript' src="{{ URL::to('fullcalendar/gcal.js') }}"></script>


</body>
</html>