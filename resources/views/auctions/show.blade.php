<x-app-layout>

    <x-confetti :winner="$auction->winner_id"/>

<livewire:auctions.show :auction="$auction" />
</x-app-layout>
