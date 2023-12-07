{{-- resources/views/components/countdown-timer.blade.php --}}

@props(['auction'])

<div
    x-data="{
    timer: {
        days: 0,
        hours: '00',
        minutes: '00',
        seconds: '00',
    },
    countDownDate: new Date('{{$auction->end}}').getTime(),
    displayMode: 'days', // Can be 'days' or 'time'
    timerClass: 'bg-[#222222]',
    startCounter: function () {
        let runningCounter = setInterval(() => {
            let now = new Date().getTime();
            let timeDistance = this.countDownDate - now;

            // Check if the countdown is complete
             // Check if the countdown is complete
            if (timeDistance < 0) {
                clearInterval(runningCounter);
                this.displayMode = 'sold'; // Set display mode to 'sold'
                this.timerClass = 'bg-[#222222]'; // Set the class to default
                return;
            }


            // Calculate the timer values
            this.calculateTimer(timeDistance);

            // Update the display mode
            if (this.countDownDate - now > 24 * 60 * 60 * 1000) { // More than 24 hours left
                this.displayMode = 'days';
            } else if (this.countDownDate - now <= 24 * 60 * 60 * 1000 && this.countDownDate - now > 0) { // 24 hours or less
                this.displayMode = 'time';
            }

            // Update the class based on remaining time
            this.timerClass = timeDistance <= (3 * 60 * 60 * 1000) ? 'bg-[#D35443]' : 'bg-[#222222]';
        }, 1000);
    },
    resetTimer: function() {
        this.timer.days = 0;
        this.timer.hours = '00';
        this.timer.minutes = '00';
        this.timer.seconds = '00';
    },
    calculateTimer: function(timeDistance) {
        this.timer.days = Math.ceil(timeDistance / (1000 * 60 * 60 * 24)); // Round up for days
        this.timer.hours = this.formatCounter(Math.floor((timeDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        this.timer.minutes = this.formatCounter(Math.floor((timeDistance % (1000 * 60 * 60)) / (1000 * 60)));
        this.timer.seconds = this.formatCounter(Math.floor((timeDistance % (1000 * 60)) / 1000));
    },
    formatCounter: function (number) {
        return number.toString().padStart(2, '0');
    }
}"

    x-init="startCounter()"
>

    <div
        class="box flex justify-between items-center  transition-opacity duration-200 bottom-3 rounded-xl py-2 px-3 "
        :class="timerClass">
        <div class="p-1 rounded-xl flex justify-center items-center gap-3 px-2 text-white">
            <div class="flex gap-2 justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock stroke-gray-300"
                     width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                    <path d="M12 7v5l3 3"/>
                </svg>
                <div class="text-sm flex gap-3">
                    <span class="text-gray-300 text-lg">Time Left</span>
                    <template x-if="displayMode === 'days'">
                        <span class="text-lg text-white" x-text="timer.days + ' Days'"></span>
                    </template>
                    <template x-if="displayMode === 'time'">
                        <div class="text-lg text-white">
                            <span x-text="timer.hours"></span>:
                            <span x-text="timer.minutes"></span>:
                            <span x-text="timer.seconds"></span>
                        </div>
                    </template>
                    <template x-if="displayMode === 'sold'">
                        <div class="text-lg text-white">
                            <span x-text="'Sold For'"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="flex gap-1 justify-center items-center ">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up stroke-gray-300"
                 width="24" height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 5l0 14"/>
                <path d="M18 11l-6 -6"/>
                <path d="M6 11l6 -6"/>
            </svg>
            <template x-if="displayMode !== 'sold'">
                <span class="text-gray-300 text-lg">High Bid</span>
            </template>
            <span class="text-white text-lg">د.ل.{{number_format($auction->end_price)}}</span>
        </div>
        <div class="flex gap-1 justify-center items-center ">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hash stroke-gray-300" width="24"
                 height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 9l14 0"/>
                <path d="M5 15l14 0"/>
                <path d="M11 4l-4 16"/>
                <path d="M17 4l-4 16"/>
            </svg>
            <span class="text-gray-300 text-lg">Bids</span>
            <span class="text-white text-lg">{{$auction->bids->count()}}</span>
        </div>
        <div class="flex gap-1 justify-center items-center ">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message stroke-gray-300"
                 width="24" height="24"
                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 9h8"/>
                <path d="M8 13h6"/>
                <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"/>
            </svg>
            <span class="text-gray-300 text-lg">Comments</span>
            {{--            TODO: make this the commants--}}
            <span class="text-white text-lg">{{$auction->bids->count()}}</span>
        </div>
    </div>
</div>
