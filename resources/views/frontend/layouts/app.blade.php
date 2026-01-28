<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tour Package Price Calculator - Atripguys</title>

    <!-- Bootstrap 5.3 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Font Awesome for calendar icon -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <link href="{{ asset('asset/frontend/img/favicon.jpg') }}" rel="icon">


    <link href="{{ asset('asset/css/main.css') }}" rel="stylesheet" />
    
</head>

<body>
    @include('frontend.layouts.header')

    @yield('content')

    @include('frontend.layouts.footer')
</body>
</html>
