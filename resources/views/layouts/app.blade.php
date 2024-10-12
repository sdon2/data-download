<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Home') || {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @include('partials.navbar')

        <div class="az-content az-content-dashboard">
            <div class="container">
                <div class="az-content-body">
                    <div class="az-dashboard-one-title">
                        <div>
                            <h2 class="az-dashboard-title">Hi, welcome back!</h2>
                            <p class="az-dashboard-text">Your web analytics dashboard template.</p>
                        </div>
                        <div class="az-content-header-right">
                            <div class="media">
                                <div class="media-body">
                                    <label>Start Date</label>
                                    <h6>Oct 10, 2018</h6>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media">
                                <div class="media-body">
                                    <label>End Date</label>
                                    <h6>Oct 23, 2018</h6>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media">
                                <div class="media-body">
                                    <label>Event Category</label>
                                    <h6>All Categories</h6>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            <a href="" class="btn btn-purple">Export</a>
                        </div>
                    </div><!-- az-dashboard-one-title -->

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
</body>

</html>
