<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Favorites')}}

        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 grid-cols-1  gap-6 mx-5">
                @foreach($auctions as $auction)

                    <div class="relative" onclick="location.href='{{route('auctions.show', $auction)}}'">

                        <div class="flex flex-col gap-3 cursor-pointer">

                            <div class="relative">

                                <!-- component -->
                                <div class="group"
                                     x-data="{ activeSlide: 1, slides: {{ count($auction->media) }} }">
                                    <div class="relative">
                                        <!-- Slides -->
                                        @foreach($auction->media as $key => $media)
                                            <div x-show="activeSlide === {{ $key + 1 }}">
                                                <img src="{{$media->getUrl()}}"
                                                     alt=""
                                                     class="w-full h-52 rounded-xl object-cover shadow-md">
                                            </div>
                                        @endforeach

                                        <!-- Prev/Next arrow buttons (hidden by default) -->
                                        <div
                                            class="box flex justify-between items-center mx-2 absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <button class="bg-white p-1 rounded-full flex justify-center items-center"
                                                    x-on:click="activeSlide = activeSlide === 1 ? slides : activeSlide - 1"
                                                    onclick="event.stopPropagation();">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-chevron-left" width="24"
                                                     height="24"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M15 6l-6 6l6 6"></path>
                                                </svg>
                                            </button>
                                            <button class="bg-white p-1 rounded-full flex justify-center items-center"
                                                    x-on:click="activeSlide = activeSlide === slides ? 1 : activeSlide + 1"
                                                    onclick="event.stopPropagation();">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-chevron-right" width="24"
                                                     height="24"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 6l6 6l-6 6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <x-countdown :auction="$auction" />
                                    </div>


                                </div>


                            </div>

                            <div>
                                <h1 class="text-base font-bold ">
                                    {{ $auction->title}}
                                </h1>
                                <h1 class="font-thin text-base text-gray-500 ">
                                    {{ $auction->about}}
                                </h1>
                                <h1 class="text-base font-bold ">{{number_format($auction->end_price)}}د.ل.</h1>

                            </div>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </div>
</x-app-layout>
