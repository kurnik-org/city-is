<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        @if ($tickets->isEmpty())
            <div class="pt-6">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="py-6 text-xl text-gray-900 px-6 col-span-2">
                            No tickets have been closed yet.
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h2 class="text-3xl text-center pt-6">
                {{ __('All closed tickets') }}
            </h2>
            @foreach ($tickets as $ticket)
                @include('common.ticket_index_item', ['ticket' => $ticket])                
            @endforeach
        @endif
    </div>
</x-app-layout>