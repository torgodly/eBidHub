@props(['auction'])
<div id="card" class="flex flex-col items-center gap-6 w-1/2">
    <div class="sticky  top-32 flex flex-col items-center gap-6  w-full">
        <div
            class="max-w-xs w-full bg-white border border-gray-200 rounded-lg shadow  p-6 flex flex-col justify-center text-center drop-shadow-xl">

            <h1 class="font-bold text-4xl">د.ل.{{number_format($auction->end_price)}}</h1>
            <div class="flex flex-col gap-3 justify-center items-center">

                <x-text-input wire:model="bid" type="number"
                              class="w-full h-12 mt-4 text-center text-2xl font-bold border border-gray-200 rounded-lg shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                              required/>
                <x-input-error :messages="$errors->get('bid')" class="mt-2"/>
                <x-primary-button class="w-full flex justify-center mt-4 h-12 capitalize !text-base !font-bold"
                                  wire:click="CreateBid">
                    <x-loading-indicator wire:loading="CreateBid"/>

                    {{__('Bid')}}
                </x-primary-button>

            </div>
        </div>

    </div>
</div>
