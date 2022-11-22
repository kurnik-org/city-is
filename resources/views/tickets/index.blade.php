<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        @if (!$tickets)
        <div class="pt-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="pt-6 text-xl text-gray-900 px-6 col-span-2">
                        Currently, no tickets have been reported.
                    </div>
                </div>
            </div>
        </div>
        @else
        @if (Auth::user()->role_id == User::getRoleId('citizen'))
        <h1 class="text-3xl text-center">
            {{ __('My tickets') }}
        </h1>
        @foreach ($tickets as $ticket)
        @if (Auth::user()->name == $ticket->author->name)
            @include('common.ticket_index_item', ['ticket' => $ticket])
        @endif
        @endforeach
        @endif

        @if (Auth::user()->role_id == User::getRoleId('citizen'))
        <h2 class="text-3xl text-center pt-6">
            {{ __('Other tickets') }}
        </h2>
        @else
        <h2 class="text-3xl text-center pt-6">
            {{ __('All tickets') }}
        </h2>
        @endif
        @foreach ($tickets as $ticket)
        @if (Auth::user()->name != $ticket->author->name)
            @include('common.ticket_index_item', ['ticket' => $ticket])
        @endif
        @endforeach
        @endif
    </div>
</x-app-layout>
