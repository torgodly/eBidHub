@props(['name' , 'value' => null])
<!-- Toggle -->

<div dir="ltr"
     x-data="{ value: @js($value) }"
     class="flex  items-center justify-end"
     x-id="['toggle-label']"
>
    <input type="hidden" name="{{ $name }}" :value="value?1:0">


    <!-- Button -->
    <button
        x-ref="toggle"
        @click="value = ! value"
        wire:click="{{$attributes->wire('click')->value()}}"
        type="button"
        role="switch"
        :aria-checked="value"
        :aria-labelledby="$id('toggle-label')"
        :class="value ? 'bg-green-400' : 'bg-slate-300'"
        class="relative ml-4  inline-flex w-14 rounded-full py-1 transition"
    >
        <span
            :class="value ? 'translate-x-7' : 'translate-x-1'"
            class="bg-white h-6 w-6 rounded-full transition shadow-md"
            aria-hidden="true"
        ></span>
    </button>
</div>

