<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Hi! Welcome ") . ' ' . Auth::user()->name }}
                </div>
            </div>

            {{-- Latest Events Section --}}
            <div class="bg-white dark:bg-gray-800 mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Latest Events</h3>
                    <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2">
                        @forelse ($latestEvents as $event)
                            <div class="lg:flex bg-slate-100 rounded-md">
                                <img class="object-cover w-full h-56 rounded-lg lg:w-64"
                                     src="{{ asset('/storage/' . $event->image) }}"
                                     alt="{{ $event->title }}">

                                <div class="flex flex-col justify-between py-6 lg:mx-6">
                                    <a href="{{ route('eventShow', $event->id) }}"
                                       class="text-xl font-semibold text-gray-800 hover:underline dark:text-white">
                                        {{ $event->title }}
                                    </a>

                                    <span class="text-sm text-white dark:text-gray-300 bg-indigo-400 rounded-md p-2">
                                        {{ $event->location->name }}
                                    </span>
                                    <div class="flex flex-wrap">
                                        @foreach ($event->tags as $tag)
                                        <p class="text-sm p-2 bg-slate-200 rounded-md mr-2 mb-2">{{ $tag->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">
                                No latest events found
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- All Events Section --}}
            <div class="bg-white dark:bg-gray-800 mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">All Events</h3>
                    <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2">
                        @forelse ($events as $event)
                            <div class="lg:flex bg-slate-100 rounded-md">
                                <img class="object-cover w-full h-56 rounded-lg lg:w-64"
                                     src="{{ asset('/storage/' . $event->image) }}"
                                     alt="{{ $event->title }}">

                                <div class="flex flex-col justify-between py-6 lg:mx-6">
                                    <a href="{{ route('eventShow', $event->id) }}"
                                       class="text-xl font-semibold text-gray-800 hover:underline dark:text-white">
                                        {{ $event->title }}
                                    </a>

                                    <span class="text-sm text-white dark:text-gray-300 bg-indigo-400 rounded-md p-2">
                                        {{ $event->location->name }}
                                    </span>
                                    <div class="flex flex-wrap">
                                        @foreach ($event->tags as $tag)
                                        <p class="text-sm p-2 bg-slate-200 rounded-md mr-2 mb-2">{{ $tag->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400">
                                No events found
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
