{{-- Blueprint semua halaman di sini--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
    <body class="font-sans antialiased bg-gray-100 flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')
        
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- header --}}
            @include('layouts.partials.header')

            <main class="flex-1 overflow-y-auto bg-gray-100">
                <div class="p-6">
                    @yield('content')
                </div>
                {{-- Footer --}}
                @include('layouts.partials.footer')
            </main>
        </div>
        {{-- Tempat Script yang ada di halaman --}}
        @stack('scripts')
    </body>
</html>