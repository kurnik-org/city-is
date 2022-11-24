<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        @if ($tickets->isEmpty())
            <a href="{{ route('tickets.create')}}">
                <div class="pt-6">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white hover:bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="py-6 text-xl text-gray-900 px-6 col-span-2">
                                You do not have any reported tickets at the moment.
                            </div>
                            <div class="pb-6 text-xl text-gray-900 px-6 col-span-2">
                                Would you like to report one? Click here!
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @else
            <h1 class="text-3xl text-center">
                {{ __('My tickets') }}
            </h1>
            @foreach ($tickets as $ticket)
                    @include('common.ticket_index_item', ['ticket' => $ticket])
            @endforeach
        @endif
    </div>
</x-app-layout>