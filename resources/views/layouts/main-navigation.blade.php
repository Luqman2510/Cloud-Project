<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex items-center space-x-4">
                <!-- Conditional check to navigate to welcome page for unauthenticated users -->
                <a href="{{ Auth::check() ? (isset($event) ? route('eventShow', ['id' => $event->id]) : route('welcome')) : route('welcome') }}" class="flex items-center space-x-2">
                <!-- Logo on the Left -->
                    <img src="{{ asset('storage/galleries/LOGO_KPPIM_BULAT.png') }}" alt="KPPIM Logo" class="h-6 w-6">
                    <!-- Text on the Right -->
                    <div>
                        <h1 class="text-sm font-bold text-indigo-100">KPPIM Event</h1>
                        <hr class="border-t-2 border-indigo-400 w-16 mt-1">
                    </div>
                </a>

                <!-- Events Link (beside the logo) -->
                @if (!request()->routeIs('eventShow'))
                    <x-nav-link :href="route('eventIndex')" :active="request()->routeIs('eventIndex')">
                        {{ __('Events') }}
                    </x-nav-link>
                @endif
            </div>

            <!-- Authentication Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">Login</x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">Register</x-nav-link>
                @endauth
            </div>

            <!-- Hamburger for mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 
                    dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 
                    focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
