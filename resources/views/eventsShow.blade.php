<x-main-layout>
    <div class="mb-16 flex flex-wrap">
        <div class="mb-6 w-full shrink-0 grow-0 basis-auto lg:mb-0 lg:w-6/12 lg:pr-6">
            <div class="flex flex-col">
                <div class="ripple relative overflow-hidden rounded-lg bg-cover bg-[50%] bg-no-repeat shadow-lg dark:shadow-black/20"
                    data-te-ripple-init data-te-ripple-color="light">
                    <img class="w-full" 
                     src="{{ asset('/storage/' . $event->image) }}"  alt="event image"/>
                    <a href="#!">
                        <div
                            class="absolute top-0 right-0 bottom-0 left-0 h-full w-full overflow-hidden bg-[hsl(0,0%,98.4%,0.2)] bg-fixed opacity-0 transition duration-300 ease-in-out hover:opacity-100">
                        </div>
                    </a>
                </div>
                @auth
                    <div class="flex space-x-2 p-4" x-data="{
                        eventLike: @js($like),
                        savedEvent: @js($savedEvent),
                        attending: @js($attending),
                        onHandleLike() {
                            axios.post(`/events-like/{{ $event->id }}`).then(res => {
                                this.eventLike = res.data
                            })
                        },
                        onHandleSavedEvent() {
                            axios.post(`/events-saved/{{ $event->id }}`).then(res => {
                                this.savedEvent = res.data
                            })
                        },
                        onHandleAttending() {
                            axios.post(`/events-attending/{{ $event->id }}`).then(res => {
                                this.attending = res.data
                            })
                        }
                    }">
                        <button type="button" @click="onHandleLike"
                            class="text-white  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :class="eventLike ? 'bg-red-700 hover:bg-red-800' : 'bg-slate-400 hover:bg-slate-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-3.5 h3.5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                            </svg>
                            Like
                        </button>
                        <button type="button" @click="onHandleSavedEvent"
                            class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :class="savedEvent ? 'bg-yellow-700 hover:bg-yellow-800' : 'bg-slate-400 hover:bg-slate-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-3.5 h3.5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                            </svg>
                            Save
                        </button>
                        @auth
                        @if(!auth()->user()->is_admin)
                        <button type="button" @click="onHandleAttending"
                            class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :class="attending ? 'bg-indigo-700 hover:bg-indigo-800' : 'bg-slate-400 hover:bg-slate-500'">
                            Attending
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                        @endif
                        @endauth
                    </div>
                @endauth
                <div class="flex flex-col p-4">
                    <span class="text-indigo-600 font-semibold">Host Info</span>
                    <div class="flex space-x-4 mt-6 bg-slate-200 p-2 rounded-md">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg></span>
                        <div class="flex flex-col">
                            <span class="text-xl">{{ $event->user->name }}</span>
                            <span class="text-xl">{{ $event->user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="w-full shrink-0 grow-0 lg:w-6/12 lg:pl-6 bg-slate-50 rounded-md p-4">
            <!-- Event Title -->
            <h3 class="mb-4 text-2xl font-bold text-black-700">{{ $event->title }}</h3>

            <!-- Location & Place -->
            <div class="mb-4 flex items-center text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-2 text-indigo-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <div class="text-black-700">{{ $event->location->name }}, {{ $event->place->name }}</div>
            </div>

            <!-- Event Time -->
            <p class="mb-4 text-sm text-gray-600">
                Start Time: <time>{{ $event->start_time }}</time>
            </p>

            <!-- Event Date -->
            <div class="mb-4 text-sm text-gray-600">
                Date: 
                <span class="mx-2">{{ $event->start_date->format('d/m/Y') }}</span> - <span class="mx-2">{{ $event->end_date->format('d/m/Y') }}</span>
            </div>

            <!-- Venue -->
            <p class="mb-4 text-sm text-gray-600">
                Venue: {{ $event->address }}
            </p>

            <!-- Tags -->
            <div class="mb-4">
                @foreach ($event->tags as $tag)
                    <span class="inline-block p-1 m-1 bg-indigo-300 rounded">{{ $tag->name }}</span>
                @endforeach
            </div>

            <!-- Description -->
            <p class="text-sm text-neutral-700">
                {{ $event->description }}
            </p>
        </div>

    </div>

</x-main-layout>
