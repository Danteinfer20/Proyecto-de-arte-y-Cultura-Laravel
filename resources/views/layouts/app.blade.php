<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
    @include('layouts.header')
    
    <main class="main-content">
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <script src="{{ asset('js/menu.js') }}"></script>
    @yield('scripts')

    
</body>
</html>