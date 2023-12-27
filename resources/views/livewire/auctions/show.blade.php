<div>

    <div
        class="max-w-7xl mx-auto  pt-10 relative md:px-0  px-6 "
        x-data="{
            ShowDescription: false , ShowUtilities: false}">

        <div class="flex justify-between items-center">
            <div class="flex justify-start  flex-col ">
                <h1 class="text-2xl font-bold">{{$auction->title}}</h1>
                <div class="flex justify-center items-center">
                    <h6

                        class="text-base font-thin"><span class="text-base font-bold">~</span> {{$auction->about}}</h6>
                </div>

            </div>
            <div class="md:flex justify-start items-center gap-2 hidden ">
                <div class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" stroke-width="1"
                         stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M8 9h-1a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-8a2 2 0 0 0 -2 -2h-1"></path>
                        <path d="M12 14v-11"></path>
                        <path d="M9 6l3 -3l3 3"></path>
                    </svg>
                    <span class="text-sm font-bold underline">{{__('Share')}}</span>
                </div>
                <div class="flex gap-2">
                    <div class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 "
                             viewBox="0 0 24 24" stroke-width="1"
                             stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>
                        </svg>
                    </div>

                    <span class="text-sm font-bold underline">{{__('Likes')}}</span>
                </div>
            </div>
        </div>
        <div class="mt-2 md:grid grid-rows-2 grid-cols-4  rounded-xl overflow-clip  gap-2 relative  hidden" id="images">
            @foreach($auction->media->take(5) as $media)
                <img src="{{$media->getUrl()}}" alt=""
                     class="w-full h-full object-cover shadow-md">
            @endforeach
            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'Show-all-photos')"
                class="absolute md:bottom-10 bottom-2  bg-white border rounded-xl border-black right-10 flex justify-center items-center gap-2 px-4 py-2 cursor-pointer "

            >
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-grid-dots" width="16px"
                     height="16px" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M5 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M19 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M5 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    <path d="M19 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                </svg>
                <p class="text-sm font-bold">{{__('Show all photos')}}</p>
            </button>

        </div>
        <div class="group contents md:hidden"
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
            </div>


        </div>
        <div class="flex flex-col md:flex-row justify-between  !mt-10 gap-14  ">

            <div class="md:w-3/4 w-full !-mt-5">
                <x-big-countdown :auction="$auction"/>

                <div>

                    <h1 class="text-gray-600 py-2 text-right">
                        Ending {{\Carbon\Carbon::parse($auction->end)->format('d F H:m:a')}}</h1>
                    <div>


                        <div class="grid grid-cols-2 w-full border rounded-md ">

                            @foreach($auction->info as $key => $value)
                                <div class="flex   w-full border-b border-b-gray-300">
                                    <div class="bg-gray-200 rounded-l-sm p-2 font-bold w-1/3 box-border">
                                        {{$key}}
                                    </div>
                                    <div class="p-2 w-2/3">
                                        {{$value}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                    </div>
                    <div class="md:hidden block mt-8">
                        <x-bid-card :auction="$auction"/>

                    </div>

                    <div class="mt-8" x-data="{expanded: false}">
                        <h1 class="text-2xl font-bold capitalize">{{__('About this Auction')}}</h1>
                        <div class=" overflow-hidden">
                            <div class="text-base font-light text-black mt-4 prose "
                                 :class="!expanded?'line-clamp-5':''">
                                {{\Illuminate\Mail\Markdown::parse($auction->description)}}

                            </div>
                        </div>

                        <div class="mt-4 flex items-center cursor-pointer" x-show="!expanded">
                            <h1 class="text-base font-bold underline " @click="expanded = ! expanded">
                                {{__('Show more')}}
                            </h1>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-chevron-right"
                                 width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 6l6 6l-6 6"></path>
                            </svg>
                        </div>
                        <div class="mt-4 flex items-center cursor-pointer" x-show="expanded">
                            <h1 class="text-base font-bold underline " @click="expanded = ! expanded">
                                {{__('Show less')}}
                            </h1>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-tabler icon-tabler-chevron-right"
                                 width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 6l6 6l-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                    </div>

                    <div class="mt-8 w-fit w-full">
                        <h1 class="text-2xl font-bold capitalize">{{__('Activities')}}</h1>
                        <div class="flex justify-start items-center mt-4 w-full">
                            <x-commants-section :comments="$activities"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:contents  hidden">
                <x-bid-card :auction="$auction"/>
            </div>
        </div>


    </div>
    <style>
        #images > :first-child {

            grid-row: span 2;
            grid-column: span 2;

        }
    </style>


    @script
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('eb88c7fb8f20568f431b', {
            cluster: 'mt1'
        });

        var channelBid = pusher.subscribe('Bid-channel');
        channelBid.bind('Bid-event', function (data) {

            $wire.dispatch('bid-placed');

        });
        var channelwinner = pusher.subscribe('AuctionWinner-channel');
        channelwinner.bind('AuctionWinner-event', function (data) {

            //if the auth user is the winner alert him
            if (data.user_id == {{auth()->user()->id}}) {
                initConfetti();
                render();
            }


        });

    </script>
    @endscript
    <x-modal name="Show-all-photos" focusable >
        <div class="flex justify-center items-center gap-2 p-6">
            <x-splade :auction="$auction"/>
        </div>
    </x-modal>
</div>
