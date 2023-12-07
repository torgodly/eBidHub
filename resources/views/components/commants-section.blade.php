@props(['comments'])

<div class="flow-root">
    <ul role="list" class="mb-8">
        @foreach($comments as $comment)
            @if($comment instanceof \App\Models\Comment)
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <img
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white"
                                    src="https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80"
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
                                <div class="mt-2 text-sm text-gray-700">
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
                                    src="https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80"
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
</div>
