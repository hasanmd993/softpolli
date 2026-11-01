<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'SoftPolli - Smart Software Solutions') }}</title>
    <link rel="shortcut icon" href="/images/SP-logo.png" type="image/x-icon">
    <meta name="description" content="SoftPolli engineers scalable ERP systems, custom web applications, POS software, and digital solutions for modern businesses.">
    <meta name="theme-color" content="#0e1330">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans text-navy-900 bg-white antialiased selection:bg-brand selection:text-white">
    @inertia
</body>
</html>
