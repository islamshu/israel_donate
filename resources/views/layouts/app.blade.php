<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Donation')</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='32' fill='%230f172a'/%3E%3Cpath d='M32 50s-16-9.8-16-22c0-5.5 4.5-10 10-10 3.2 0 6.1 1.5 8 4 1.9-2.5 4.8-4 8-4 5.5 0 10 4.5 10 10 0 12.2-16 22-16 22z' fill='%23ef4444'/%3E%3Cpath d='M28 22h8v6h6v8h-6v6h-8v-6h-6v-8h6z' fill='white'/%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

    @yield('content')

</body>
</html>