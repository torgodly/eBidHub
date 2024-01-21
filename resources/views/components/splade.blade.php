@props(['auction'])
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>

<style>
    .splide__pagination__page.is-active {
        background: #333;
    }
</style>

<div wire:ignore
    x-data="{
        init() {
            new Splide(this.$refs.splide, {
                perPage: 1,
                gap: '0.5rem',
                breakpoints: {
                    640: {
                        perPage: 1,
                    },
                },
            }).mount()
        },
    }"
>
    <section x-ref="splide" class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($auction->media as $media)
                    <li class="splide__slide flex flex-col items-center justify-center pb-8">
                        <img class="w-full" src="{{$media->getUrl()}}" alt="placeholder image">
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
