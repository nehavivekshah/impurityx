<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Customer Relationship Management')</title>

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" sizes="180x180">
        <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" sizes="32x32" type="image/png">
        <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" sizes="16x16" type="image/png">
        <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg">

        <!--Bootstrap 5 library-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @yield('headlink')
        
    </head>
    <body class="bg-light app-body">
        @if(Auth::check())
            @include('backend.inc.sidebar')
        @endif
        @yield('content')
        
        @if (Session::has('success'))
            <div class="response-msg">
                <div class="alert alert-success shadow" role="alert">
                    {{ Session::get('success') }}
                </div>
            </div>
        @elseif (Session::has('error'))
            <div class="response-msg">
                <div class="alert alert-danger shadow" role="alert">
                    {{ Session::get('error') }}
                </div>
            </div>
        @endif
        
        @if ($errors->any())
        <div class="response-msg">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        
        <!--@if (session('error'))
        <div class="response-msg">
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        </div>
        @endif
        
        @if (session('status'))
        <div class="response-msg">
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        </div>
        @endif-->
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    @yield('footlink')
    
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
</html>