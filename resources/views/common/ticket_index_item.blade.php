<div class="pt-6">
    <div class="max-w-7xl mx-auto">
        <a href="{{ route('tickets.show', $ticket->id)}}">
            <div class="bg-white hover:bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between">
                    <div class="pt-6 text-xl text-gray-900 px-6 col-span-2">
                        {{ $ticket->title }}
                    </div>
                </div>
                <div class="px-6 mt-6 text-gray-900">
                    <div class="flex justify-between">
                        <div>Author:</div>
                        State: {{ $ticket->state->user_friendly_string() }}
                    </div>
                </div>
                <div class="px-6 text-gray-900 ">
                    <div class="flex justify-between">
                        <div class= "font-extrabold">{{ $ticket->author->name }}</div>
                        <div class="mb-6">Last updated: {{ $ticket->updated_at }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>