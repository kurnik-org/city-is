<div class="pt-6">
    <div class="max-w-7xl mx-auto">
        <a href="{{ route('service_requests.show', $sr->id)}}">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between">
                    <div class="pt-6 text-xl text-gray-900 px-6 col-span-2">
                        {{ $sr->title }}
                    </div>
                </div>
                <div class="px-6 mt-6 text-gray-900">
                    <div class="flex justify-between">
                        <div>Assigned technician:</div>
                        State: {{ $sr->state->user_friendly_string() }}
                    </div>
                </div>
                <div class="px-6 text-gray-900 ">
                    <div class="flex justify-between">
                        <div class= "font-extrabold">{{ User::where('id', $sr->technician_id)->first()->name }}</div>
                        <div class="mb-6">Last updated: {{ $sr->updated_at }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
