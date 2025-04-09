<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dan - IMS</title>
    <!-- Stylesheets -->
    <script src="{{ asset('common/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen bg-gray-50">

    <!-- Navigation Bar -->
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <a href="/">
                            <img class="h-8"
                                src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                alt="Your Company">
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <x-nav-link href="/dashboard" :active="request()->is('dashboard')">Dashboard</x-nav-link>
                            <x-nav-link href="/inventory" :active="request()->is('inventory')">Inventory</x-nav-link>
                            <x-nav-link href="/clock-in-out"
                                :active="request()->is('clock-in-out')">Attendance</x-nav-link>
                        </div>
                    </div>
                </div>

                <!-- Authentication Links -->
                <div class="hidden md:block">
                    @guest
                        <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                        <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>
                    @endguest

                    @auth
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium cursor-pointer">Log
                                Out</button>
                        </form>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex md:hidden">
                    <button id="mobile-menu-toggle" type="button"
                        class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-none"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>

                        <!-- Menu open icon -->
                        <svg id="menu-icon-open" class="block h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>

                        <!-- Menu close icon -->
                        <svg id="menu-icon-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="md:hidden hidden bg-gray-800" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <a href="/dashboard"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Dashboard</a>
            <a href="/inventory"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Inventory</a>
            <a href="/clock-in-out"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Attendance</a>
        </div>

        <div class="border-t border-gray-700 pt-4 pb-3 px-2">
            @guest
                <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>
            @endguest

            @auth
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium cursor-pointer">Log
                        Out</button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                {{ $header }}
                <p id="current-time" class="text-sm text-gray-500">
                    {{ now()->format('l, F j, Y g:i:s A') }}
                </p>
            </div>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="flex-grow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer Component -->
    <x-footer></x-footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            toggleBtn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        });

        function updateTime() {
            const now = new Date();
            const options = {
                timeZone: 'America/Los_Angeles',
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            };
            const timeString = now.toLocaleString('en-US', options);
            document.getElementById('current-time').textContent = timeString;
        }

        // Update time every second
        setInterval(updateTime, 1000);
    </script>

</body>
</html>