<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('MIX_VUE_APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">

    <style>
        #app {
            font-family: Montserrat,serif;
            font-size: 13px;
            line-height: 18px;
            color: #6a6a6a;
            font-weight: 400;
            background-color: #fff;
            overflow-x: hidden!important;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="antialiased">
<div id="app" class="grey lighten-5">
    <router-view />
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

