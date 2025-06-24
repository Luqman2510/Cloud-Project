<x-main-layout>
    <!-- component -->
    <section class="bg-white dark:bg-gray-900">
        <div class="container px-6 py-10 mx-auto">
            <h1 class="text-3xl font-semibold text-gray-800 capitalize lg:text-4xl dark:text-white">Latest Events</h1>

            <div class="grid grid-cols-1 gap-8 mt-8 md:mt-16 md:grid-cols-2">
                @if($events->count() > 0)
                    @foreach ($events as $event)
                        <div class="lg:flex bg-slate-100 rounded-md">
                            <img class="object-cover w-full h-56 rounded-lg lg:w-64" src="{{ asset('/storage/'. $event->image) }}"alt="{{ $event->title}}">

                            <div class="flex flex-col justify-between py-6 lg:mx-6">
                                <a href="{{ route('eventShow', $event->id) }}"
                                    class="text-xl font-semibold text-gray-800 hover:underline dark:text-white ">
                                    {{ $event->title }}
                                </a>

                                <span class="text-sm text-white dark:text-gray-300 bg-indigo-400 rounded-md p-2">
                                    {{ $event->location ? $event->location->name : 'No location' }}
                                </span>
                                <span class="flex flex-wrap space-x-2">
                                    @if($event->tags)
                                        @foreach ($event->tags as $tag)
                                            <p class="text-sm p-1 bg-slate-200 rounded-md">{{ $tag->name }}</p>
                                        @endforeach
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 text-center py-12">
                        <h3 class="text-xl text-gray-600 dark:text-gray-400">Welcome to Laravel Event Project!</h3>
                        <p class="text-gray-500 mt-4">The application is running successfully on Google Cloud Run.</p>
                        <p class="text-gray-500 mt-2">No events are currently available. Please check back later or contact the administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-main-layout>