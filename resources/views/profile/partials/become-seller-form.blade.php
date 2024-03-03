<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Become a Seller') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Become a seller and start selling your products.') }}
        </p>
    </header>

    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-seller')"
    >{{ __('Become a Seller') }}</x-primary-button>

    <x-modal name="confirm-seller" :show="$errors->has('password')" focusable>
        <form method="post" action="{{ route('sellers.create') }}" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to become a seller?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once you become a seller, you will be able to sell your products. Please enter your password to confirm you would like to become a seller.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Become a Seller') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
