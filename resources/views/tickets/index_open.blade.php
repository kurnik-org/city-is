<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        @if ($tickets->isEmpty())
            @if (Auth::user()->role_id == User::getRoleId('citizen'))
                <a href="{{ route('tickets.create')}}">
                    <div class="pt-6">
                        <div class="max-w-7xl mx-auto">
                            <div class="bg-white hover:bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="py-6 text-xl text-gray-900 px-6 col-span-2">
                                    No tickets are in open state at this moment.
                                </div>
                                <div class="pb-6 text-xl text-gray-900 px-6 col-span-2">
                                    Are you aware of any problem in the city that requires attention? Click here to report it!
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @else
                <div class="pt-6">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="py-6 text-xl text-gray-900 px-6 col-span-2">
                                No tickets are in open state at this moment.
                            </div>                            
                        </div>
                    </div>
                </div>
            @endif
        @else
            <h2 class="text-3xl text-center pt-6">
                {{ __('All open tickets') }}
            </h2>
            @foreach ($tickets as $ticket)
                @include('common.ticket_index_item', ['ticket' => $ticket])                
            @endforeach
        @endif
    </div>
</x-app-layout>