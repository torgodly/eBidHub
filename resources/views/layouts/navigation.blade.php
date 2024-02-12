<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden gap-8 sm:-my-px sm:ms-10 sm:flex" >

                    <x-nav-link :href="route('auctions.index')" :active="request()->routeIs('auctions.index')">
                        {{ __('Auctions') }}
                    </x-nav-link>

                    <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')">
                        {{ __('Favorites') }}
                    </x-nav-link>

                    <x-nav-link :href="route('auctions.won-auctions')"
                                :active="request()->routeIs('auctions.won-auctions')">
                        {{ __('My Won Auctions') }}
                    </x-nav-link>

                </div>
            </div>

            <!-- Settings Dropdown -->

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-500 bg-white hover:drop-shadow-glow focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->balance ?? '-' }} $</div>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="bg-red-600">

                        </div>
                        <button
                            class="inline-flex items-center  border  text-sm leading-4 font-medium rounded-full text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150   gap-2 border-gray-300 ">


                            <div >
                                @if(Auth::user()->avatar_url)
                                    <img src="{{asset(Auth::user()->getFilamentAvatarUrl())}}"
                                         alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full"/>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" aria-hidden="true"
                                         role="presentation" focusable="false"
                                         class="w-6 h-6 fill-gray-600">
                                        <path
                                            d="M16 .7C7.56.7.7 7.56.7 16S7.56 31.3 16 31.3 31.3 24.44 31.3 16 24.44.7 16 .7zm0 28c-4.02 0-7.6-1.88-9.93-4.81a12.43 12.43 0 0 1 6.45-4.4A6.5 6.5 0 0 1 9.5 14a6.5 6.5 0 0 1 13 0 6.51 6.51 0 0 1-3.02 5.5 12.42 12.42 0 0 1 6.45 4.4A12.67 12.67 0 0 1 16 28.7z"
                                            class=""></path>
                                    </svg>
                                @endif
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->is_seller || Auth::user()->is_admin)
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link href="/admin">
                                    {{ __('Admin Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="/seller">
                                    {{ __('Seller Dashboard') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link href="/seller">
                                    {{ __('Seller Dashboard') }}
                                </x-dropdown-link>
                            @endif

                        @endif


                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Hamburger -->

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link href="#" :active="false">
                <div class="text-green-500 font-bold text-base">{{__('Your Balance Is')}}
                    : {{ Auth::user()->balance ?? '-' }} $
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="/" :active="request()->routeIs('/')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user()->is_seller || Auth::user()->is_admin)
                @if(Auth::user()->is_admin)
                    <x-responsive-nav-link href="/admin">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/seller">
                        {{ __('Seller Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link href="/seller">
                        {{ __('Seller Dashboard') }}
                    </x-responsive-nav-link>
                @endif

            @endif

            <x-responsive-nav-link :href="route('auctions.index')" :active="request()->routeIs('auctions.index')">
                {{ __('Auctions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')">
                {{ __('Favorites') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('auctions.won-auctions')"
                                   :active="request()->routeIs('auctions.won-auctions')">
                {{ __('My Won Auctions') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name ?? '-' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? '-' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
