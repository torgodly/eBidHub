<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
{{--    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>--}}
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800,900" rel="stylesheet"/>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireScripts
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @if(Auth::check())
        @include('layouts.navigation')
    @else
        @include('layouts.public_navigation')
        @if(request()->routeIs('auctions.index'))
            <div class="h-[50vh]">
                <img class="w-full h-[50vh] object-cover"
                     src="https://res.cloudinary.com/municibid/image/upload/v1671223582/-backgrounds/homepage/shutterstock_2198260155_1.jpg">
                <div class="absolute inset-0 bg-gradient-to-b from-gray-300 to-transparent h-[50vh]"></div>

                <div class="absolute inset-0 flex flex-col items-center justify-center  md:mt-20 mt-10 h-[50vh]">
                    <h1 class="md:text-5xl font-black text-xl	 uppercase text-center">بوابتك الإلكترونية للمزادات في ليبيا</h1>
                    <p class="text-center text-base font-semibold md:w-1/3">
                        استكشف، اكتشف، واشترِ من مجموعة واسعة من المنتجات في مختلف الفئات. نحن نضمن لك تجربة مزايدة آمنة وممتعة!.                    </p>
                    <div class="mt-4 space x-4">
                        <x-primary-button onclick="location.href='{{route('login')}}'"
                                          class="bg-blue-500 hover:bg-blue-700 ">
                            {{ __('Sign in') }}
                        </x-primary-button>
                        <x-primary-button onclick="location.href='{{route('register')}}'"
                                          class="!bg-green-500 hover:bg-green-700">
                            {{ __('Create Free Account') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <x-notifications/>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
<x-footer/>

</body>
@stack('scripts')

</html>
