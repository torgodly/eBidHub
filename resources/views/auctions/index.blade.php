<x-app-layout>
    <div class="md:py-12 py-5">


        <div class="mb-5">
            <form class="mx-auto flex justify-center items-center flex-wrap gap-3 ">
                <div>
                    <x-input-label for="price" :value="__('Price')"/>
                    <x-text-input id="price" name="price" type="number" class="mt-1 block w-full"
                                  :value="request('price')"
                                  autofocus autocomplete="price"/>
                    <x-input-error class="mt-2" :messages="$errors->get('price')"/>
                </div>
                <div>
                    <x-input-label for="min_bid" :value="__('Minimum bid')"/>
                    <x-text-input id="min_bid" name="min_bid" type="number" class="mt-1 block w-full"
                                  :value="request('min_bid')"
                                  autofocus autocomplete="min_bid"/>
                    <x-input-error class="mt-2" :messages="$errors->get('min_bid')"/>
                </div>
                <div>
                    <x-input-label for="end" :value="__('Ending')"/>
                    <x-text-input id="end" name="end" type="datetime-local" class="mt-1 block w-full"
                                  :value="request('end')"
                                  autofocus autocomplete="end"/>
                    <x-input-error class="mt-2" :messages="$errors->get('end')"/>
                </div>
                <div>
                    <x-input-label for="buy_now" :value="__('Buy Now')"/>
                    <select id="buy_now" name="buy_now"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            :value="request('buy_now')"
                            autofocus autocomplete="buy_now">
                        <option {{request('buy_now') === null ? 'selected' : ''}} value="">{{__('Select')}}</option>
                        <option value="1" {{request('buy_now') === '1' ? 'selected' : ''}}>{{__('Yes')}}</option>
                        <option value="0" {{request('buy_now') === '0' ? 'selected' : ''}}>{{__('No')}}</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('buy_now')"/>
                </div>

                <x-primary-button class="bg-blue-500 hover:bg-blue-700 text-4xl mt-6">
                    <x-tabler-filter-search/> {{ __('Search') }}
                </x-primary-button>


            </form>
        </div>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 flex md:flex-row flex-col md:gap-32 gap-5">

            <div class="w-1/3 md:flex justify-start items-start hidden  flex-col">
                <h1 class="text-2xl font-bold mb-4 flex justify-center items-center">
                    <x-tabler-category-2/>
                    <span>{{__('Categories')}}</span></h1>
                <p class="text-sm text-gray-800 cursor-pointer hover:text-blue-500 transition duration-300 ease-in-out hover:underline"dir="auto"
                     onclick="location.href='{{route('auctions.index')}}'">({{\App\Models\Auction::count()}}) {{__('All')}}</p>

                @foreach($categories as $category)

                    <p class="text-sm text-gray-800 cursor-pointer hover:text-blue-500 transition duration-300 ease-in-out hover:underline"
                       onclick="location.href='{{route('auctions.index', ['category' => $category->id])}}'">{{$category->name}} ({{$category->auctions_count}})</p>

                @endforeach
            </div>

            <div x-data="{ open: false }" class="mx-5 md:hidden">
                <button

                    @click="open = !open"
                    class="flex justify-center items-center w-full bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    id="options-menu" aria-haspopup="true" x-bind:aria-expanded="open">
                    <x-tabler-category-2/>
                    {{__('Categories')}}

                </button>
                <div x-show="open" @click.away="open = false"
                     class="origin-top-right  mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                     role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="display: none;">
                    <ul class="py-1">

                        <li class="text-gray-700 cursor-pointer hover:bg-gray-100 px-4 py-2 text-sm"
                            role="menuitem">
                            <a href="{{route('auctions.index')}}"
                               class="block  text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">{{__('All')}} ({{$auctions->count()}})</a>
                        </li>
                        @foreach($categories as $category)
                            <li class="text-gray-700 cursor-pointer hover:bg-gray-100 px-4 py-2 text-sm"
                                role="menuitem">
                                <a href="{{route('auctions.index', ['category' => $category->id])}}"
                                   class="block  text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">{{$category->name}} ({{$category->auctions_count}})</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mx-5">
                <h1 class="text-2xl font-bold mb-4 flex justify-start items-center ">
                    <x-tabler-building-store/>
                    <span>{{__('Auctions')}}</span></h1>
                <div class="grid md:grid-cols-3 grid-cols-1  gap-6 ">
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
                                                <button
                                                    class="bg-white p-1 rounded-full flex justify-center items-center"
                                                    x-on:click="activeSlide = activeSlide === 1 ? slides : activeSlide - 1"
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
                                                <button
                                                    class="bg-white p-1 rounded-full flex justify-center items-center"
                                                    x-on:click="activeSlide = activeSlide === slides ? 1 : activeSlide + 1"
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
                                            </div>
                                            <x-countdown :auction="$auction"/>
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
                                    <h1 class="text-base font-bold ">د.ل.{{number_format($auction->end_price)}}</h1>

                                </div>
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
