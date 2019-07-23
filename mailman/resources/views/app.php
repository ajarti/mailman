<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
        <link href="//use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
        <link href="//cdn.jsdelivr.net/npm/animate.css@^3.5.2/animate.min.css" rel="stylesheet">
        <link href="//cdn.jsdelivr.net/npm/quasar@^1.0.3/dist/quasar.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="mailman-app">
            <router-view></router-view>
        </div>
        <script src="//cdn.jsdelivr.net/npm/quasar@^1.0.3/dist/quasar.ie.polyfills.umd.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/vue@latest/dist/vue.js"></script>
        <script src="//cdn.jsdelivr.net/npm/vue-router@latest/dist/vue-router.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/axios@latest/dist/axios.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/quasar@^1.0.3/dist/quasar.umd.min.js"></script>
        <script src="/js/app.js"></script>
    </body>
</html>
