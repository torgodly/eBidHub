@props(['comments'])


<div class="flow-root w-full">
    <div class="flex gap-x-3">

        <div class="relative flex-auto">
            <div
                class="overflow-hidden rounded-lg pb-12 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600 bg-white">
                <label for="comment" class="sr-only">Add your comment</label>
                <input rows="2" name="comment" id="comment" wire:model="comment"
                       class="block w-full resize-none border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                       placeholder="Add your comment..."></input>
            </div>

            <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                <div class="flex items-center space-x-5">

                    <div class="flex items-center">
                        <div x-data="{mood: false}">
                            <label id="listbox-label" class="sr-only">Your mood</label>
                            <div class="relative">
                                <button @click="mood = !mood" type="button"
                                        class="relative -m-2.5 flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500"
                                        aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                <span class="flex items-center justify-center">
                  <span>
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-4.464a.75.75 0 10-1.061-1.061 3.5 3.5 0 01-4.95 0 .75.75 0 00-1.06 1.06 5 5 0 007.07 0zM9 8.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S7.448 7 8 7s1 .672 1 1.5zm3 1.5c.552 0 1-.672 1-1.5S12.552 7 12 7s-1 .672-1 1.5.448 1.5 1 1.5z"
                            clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Add your mood</span>
                  </span>
                    <!-- Selected item label, show/hide based on listbox state. -->
                </span>
                                </button>
                                <ul x-show="mood"
                                    class="absolute bottom-10 z-10 -ml-6 w-60 rounded-lg bg-white py-3 text-base shadow ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm"
                                    tabindex="-1" role="listbox" aria-labelledby="listbox-label"
                                    aria-activedescendant="listbox-option-5">
                                    <!--
                                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                                    -->
                                    <li class="bg-white relative cursor-default select-none px-3 py-2"
                                        id="listbox-option-0" role="option">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-red-500 flex h-8 w-8 items-center justify-center rounded-full">
                                                <svg class="text-white h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.039.278.352.594.672.943.954.332.269.786-.049.773-.476a5.977 5.977 0 01.572-2.759 6.026 6.026 0 012.486-2.665c.247-.14.55-.016.677.238A6.967 6.967 0 0013.5 4.938zM14 12a4 4 0 01-4 4c-1.913 0-3.52-1.398-3.91-3.182-.093-.429.44-.643.814-.413a4.043 4.043 0 001.601.564c.303.038.531-.24.51-.544a5.975 5.975 0 011.315-4.192.447.447 0 01.431-.16A4.001 4.001 0 0114 12z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 block truncate font-medium">Excited</span>
                                        </div>
                                    </li>
                                    <!--
                                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                                    -->
                                    <li class="bg-white relative cursor-default select-none px-3 py-2"
                                        id="listbox-option-1" role="option">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-pink-400 flex h-8 w-8 items-center justify-center rounded-full">
                                                <svg class="text-white h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 block truncate font-medium">Loved</span>
                                        </div>
                                    </li>
                                    <!--
                                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                                    -->
                                    <li class="bg-white relative cursor-default select-none px-3 py-2"
                                        id="listbox-option-2" role="option">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-green-400 flex h-8 w-8 items-center justify-center rounded-full">
                                                <svg class="text-white h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-4.464a.75.75 0 10-1.061-1.061 3.5 3.5 0 01-4.95 0 .75.75 0 00-1.06 1.06 5 5 0 007.07 0zM9 8.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S7.448 7 8 7s1 .672 1 1.5zm3 1.5c.552 0 1-.672 1-1.5S12.552 7 12 7s-1 .672-1 1.5.448 1.5 1 1.5z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 block truncate font-medium">Happy</span>
                                        </div>
                                    </li>
                                    <!--
                                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                                    -->
                                    <li class="bg-white relative cursor-default select-none px-3 py-2"
                                        id="listbox-option-3" role="option">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-yellow-400 flex h-8 w-8 items-center justify-center rounded-full">
                                                <svg class="text-white h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm-3.536-3.475a.75.75 0 001.061 0 3.5 3.5 0 014.95 0 .75.75 0 101.06-1.06 5 5 0 00-7.07 0 .75.75 0 000 1.06zM9 8.5c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S7.448 7 8 7s1 .672 1 1.5zm3 1.5c.552 0 1-.672 1-1.5S12.552 7 12 7s-1 .672-1 1.5.448 1.5 1 1.5z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 block truncate font-medium">Sad</span>
                                        </div>
                                    </li>
                                    <!--
                                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                                    -->
                                    <li class="bg-white relative cursor-default select-none px-3 py-2"
                                        id="listbox-option-4" role="option">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-blue-500 flex h-8 w-8 items-center justify-center rounded-full">
                                                <svg class="text-white h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 block truncate font-medium">Thumbsy</span>
                                        </div>
                                    </li>
                                    <!--
                                      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                      Highlighted: "bg-gray-100", Not Highlighted: "bg-white"
                                    -->
                                    <li class="bg-white relative cursor-default select-none px-3 py-2"
                                        id="listbox-option-5" role="option">
                                        <div class="flex items-center">
                                            <div
                                                class="bg-transparent flex h-8 w-8 items-center justify-center rounded-full">
                                                <svg class="text-gray-400 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                                                </svg>
                                            </div>
                                            <span class="ml-3 block truncate font-medium">I feel nothing</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" wire:click="addcomment"
                        class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Comment
                    <x-loading-indicator name="addcomment" class="w-3 h-3"/>
                </button>
            </div>
        </div>
    </div>
    <ul role="list" class="mt-8 ">
        @foreach($comments as $comment)
            @if($comment instanceof \App\Models\Comment)
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <img
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white"
                                    src="{{$comment->user->filament_avatar_url}}}}"
                                    alt="">

                                <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-white px-0.5 py-px">
              <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                      d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902.848.137 1.705.248 2.57.331v3.443a.75.75 0 001.28.53l3.58-3.579a.78.78 0 01.527-.224 41.202 41.202 0 005.183-.5c1.437-.232 2.43-1.49 2.43-2.903V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zm0 7a1 1 0 100-2 1 1 0 000 2zM8 8a1 1 0 11-2 0 1 1 0 012 0zm5 1a1 1 0 100-2 1 1 0 000 2z"
                      clip-rule="evenodd"/>
              </svg>
            </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900">{{$comment->user->name}}</a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">{{$comment->created_at->diffforhumans()}}</p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700 font-bold">
                                    <p>{{$comment->body}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @else
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <img
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white"
                                    src="{{asset($comment->user->getFilamentAvatarUrl())}}"
                                    alt="">

                                <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-white px-0.5 py-px">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 stroke-green-500 drop-shadow-2xl">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                        </svg>
</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-900">{{$comment->user->name}}</p>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">Bid {{$comment->created_at->diffforhumans()}}</p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700">
                                    <div
                                        class="bg-[#222222] p-2 w-fit rounded-xl flex justify-center items-center gap-2">
                                        <span class="text-gray-400 font-bold text-lg">Bid</span>
                                        <h1 class="text-base text-white font-bold">
                                            د.ل.{{number_format($comment->amount)}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            @endif
        @endforeach

    </ul>
    <div class="flex justify-center items-center mb-5">
        <x-secondary-button wire:click="loadMoreActivities" class="w-fit">
            <x-loading-indicator name="loadMoreActivities" class="w-3 h-3"/>
            {{__('Load more')}}
        </x-secondary-button>
    </div>
</div>
