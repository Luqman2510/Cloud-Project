<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Event Project</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Simple Navigation -->
        <nav class="bg-indigo-600 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <!-- Logo -->
                        <div class="flex items-center space-x-2">
                            <div class="h-8 w-8 bg-white rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-sm">K</span>
                            </div>
                            <div>
                                <h1 class="text-sm font-bold text-white">KPPIM Event</h1>
                                <div class="border-t-2 border-indigo-400 w-16"></div>
                            </div>
                        </div>
                        <!-- Events Link -->
                        <a href="/e" class="text-indigo-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Events</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="/test" class="text-indigo-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Test</a>
                        <a href="/debug" class="text-indigo-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Debug</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
