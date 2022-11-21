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
        <div class="pt-6">
            <div class="max-w-7xl mx-auto">
                <a href="{{ route('tickets.show', $ticket->id)}}">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex justify-between">
                            <div class="pt-6 text-xl text-gray-900 px-6 col-span-2">
                                {{ $ticket->title }}                           
                            </div>                            
                        </div>
                        <div class="px-6 mt-6 text-gray-900">
                            <div class="flex justify-between">
                                <div>Author:</div>
                                @if ($ticket->state == 0)
                                    State: Reported
                                @else
                                    State: Work in progress
                                @endif
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
        <div class="pt-6">
            <div class="max-w-7xl mx-auto">
                <a href="{{ route('tickets.show', $ticket->id)}}">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pt-6 text-xl text-gray-900 px-6 col-span-2">
                            {{ $ticket->title }}
                        </div>
                        <div class="px-6 mt-6 text-gray-900">
                            <div class="flex justify-between">
                                <div>Author:</div>
                                @if ($ticket->state == 0)
                                    State: Reported
                                @else
                                    State: Work in progress
                                @endif
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
        @endif
        @endforeach
        @endif
    </div>
</x-app-layout>