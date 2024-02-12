<footer class="bg-white">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8 ">
        <div class="md:flex md:justify-between max-w-2xl">
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center">
                    <img src="{{asset('images/logo.png')}}" class="h-8 me-3" alt="FlowBite Logo"/>
                </a>

            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase ">{{__('Links')}}</h2>
                    <ul class="text-gray-500 -400 font-medium">
                        <li class="mb-4">
                            <a href="/" class="hover:underline">{{__('Auctions')}}</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{route('login')}}" class="hover:underline">{{__('Sign in')}}</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{route('register')}}" class="hover:underline">{{__('Sign up')}}</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{route('contact')}}" class="hover:underline">{{__('Contact us')}}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase ">{{__('Contact')}}</h2>
                    <ul class="text-gray-500 -400 font-medium">
                        <li class="mb-4">
                            <span class="hover:underline">09200000000</span>
                        </li>
                        <li class="mb-4">
                            <span class="hover:underline">info@eBidHub.ly</span>
                        </li>
                        <li class="mb-4">
                            <span class="hover:underline">طـرابـلـس - لـيـبـيـا</span>
                        </li>
                        <li class="mb-4">
                            <a href="{{route('terms-and-conditions')}}" class="hover:underline">الشروط و الأحكام</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto -700 lg:my-8"/>
        <div class="sm:flex sm:items-center sm:justify-center" dir="auto">
          <span class="text-sm text-gray-500 sm:text-center -400">© {{now()->year}} <a href="https://flowbite.com/"
                                                                            class="hover:underline">eBidHub.ly™</a>. {{__('All Rights Reserved')}}.
          </span>

        </div>
    </div>
</footer>
