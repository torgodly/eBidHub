@props(['auction'])
<div id="card" class="flex flex-col items-center gap-6 md:w-1/2 ">


    <div class="sticky  top-32 flex flex-col items-center gap-6  w-full">
        @if($auction->status === 'closed')
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-[390px] ">
                <div
                    class="bg-gradient-to-r from-red-600 to-pink-500 text-white font-bold py-2 px-6 transform -rotate-[35deg] shadow-lg text-center text-xl capitalize rounded-3xl">
                    {{__('This Auction is Closed')}}
                </div>
            </div>
        @endif
        <div
            class="max-w-xs w-full bg-white border border-gray-200 rounded-lg shadow  p-6 flex flex-col justify-center text-center drop-shadow-xl">

            <h1 class="font-bold text-4xl">د.ل.{{number_format($auction->end_price)}}</h1>
            <div class="flex flex-col gap-3 justify-center items-center">

                <x-text-input
                    :disabled="$auction->has_winner"
                    wire:model="bid" type="number"
                    class="w-full h-12 mt-4 text-center text-2xl font-bold border border-gray-200 rounded-lg shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    required/>
                <x-input-error :messages="$errors->get('bid')" class="mt-2"/>
                <x-primary-button
                    :disabled="$auction->has_winner || $auction->status === 'closed'"
                    class="w-full flex justify-center mt-4 h-12 capitalize !text-base !font-bold"
                    wire:click="Bid" wire:target="Bid" wire:loading.attr="disabled">
                    <x-loading-indicator name="Bid"/>
                    {{__('Bid')}}
                </x-primary-button>
                @if($auction->buy_now)
                    <x-primary-button
                        :disabled="$auction->has_winner"
                        class="w-full flex justify-center  h-12 capitalize !text-base !font-bold"
                        wire:click="buyNow" wire:target="buyNow" wire:loading.attr="disabled">
                        <x-loading-indicator name="buyNow"/>
                        {{__('Buy Now')}}
                    </x-primary-button>
                @endif


            </div>
        </div>

    </div>
</div>
