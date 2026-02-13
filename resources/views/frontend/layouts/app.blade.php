<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'gfgjj')</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('asset/frontend/img/favicon.jpg') }}">

    <!-- Frontend CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/main.css') }}">
</head>

<body>

    {{-- FRONTEND HEADER --}}
    @include('frontend.layouts.header')

    {{-- PAGE CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FRONTEND FOOTER --}}
    @include('frontend.layouts.footer')

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
