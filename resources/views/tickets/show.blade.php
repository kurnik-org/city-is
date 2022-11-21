<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!--Heading-->
        <h1
            class="text-3xl text-center"
        >Ticket #{{ $ticket->id }}</h1>
        <h2
            class="text-2xl text-center"
        >{{ $ticket->title }}</h2>

        <!--Button to close the ticket-->
        @if (in_array(Auth::user()->getRole(), [User::getRoleId('admin'), User::getRoleId('city_admin')]) && ($ticket->state != Ticket::getStateId('fixed')))
        <div class="mt-4">
            <form method="POST" name="close_ticket_form" action="{{ route('tickets.update', $ticket->id) }}">
                @csrf
                @method('patch')
                <x-primary-button name="submit_close_ticket" class="w-full">Close ticket</x-primary-button>
            </form>
        </div>
        @endif

        <!--Service requests-->
        @if (Auth::user()->getRole() != User::getRoleId('citizen'))
        <div class="mt-4">
            <h3 class="text-xl">Service requests</h3>

            <!--Existing service requests-->
            <div class="items-center">
                <label
                       for="existing_service_requests"
                >Go to an existing request:</label>
                <select
                    name="existing_service_requests"
                    id="existing_service_requests"
                    onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
                    onfocus="this.selectedIndex = 0;"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20">
                    <option value="" disabled selected>Select the request</option>

                    @foreach ($ticket->service_requests as $request)
                        <option value="{{ route('service_requests.show', $request->id) }}">#{{ $request->id }}: {{ $request->title }} | {{ ServiceRequest::getStateAsUserFriendlyString($request->getState()) }}</option>
                    @endforeach

                </select>
            </div>

            @if (Auth::user()->getRole() == User::getRoleId('city_admin') && ($ticket->state != Ticket::getStateId('fixed')))
            <!--New service request-->
            <div class="mt-4">
                <label
                    for="new_request_form"
                >New service request</label>
                @if (count(ServiceRequest::where('ticket_id', $ticket->id)->get()) > 0)
                    <p class="text-red-700">One or more requests for this ticket already exist.
                        Add new request only if needed.</p>
                @endif
                <form autocomplete="off" id="new_request_form" method="POST" action="{{ route('service_requests.store') }}">
                    @csrf
                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="{{ __('Service request title') }}"
                        value="SR{{ count(ServiceRequest::where('ticket_id', $ticket->id)->get()) + 1}} for ticket #{{ $ticket->id }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-0.5"
                    />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    <select
                        name="technician_id"
                        id="technician_id"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20 mt-0.5">
                        <option value="" disabled selected>Select a technician</option>

                        @foreach (User::where('role_id', User::getRoleId('technician'))->get() as $technician)
                            <option value="{{ $technician->id }}">#{{ $technician->id }}: {{ $technician->name }} </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('technician_id')" class="mt-2" />
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <input type="hidden" name="city_admin_id" value="{{ Auth::user()->id }}">
                    <x-primary-button name="submit_new_request" class="mt-0.5">{{ __('Assign new service request') }}</x-primary-button>
                </form>
            </div>
            @endif
        </div>
        <hr class="my-8 h-px bg-gray-200 border-0 bg-black">
        @endif

        <!--Author, date, state, requests-->
        @if (Auth::user()->getRole() == User::getRoleId('city_admin'))
            <h3 class="text-xl">Original ticket details</h3>
        @endif
        <div class="mt-4 grid grid-cols-2 gap-4">
            <div class="flex items-center">
                <label class="mr-2 w-1/4"
                       for="author"
                >Author:</label>
                <input
                    type="text"
                    id="author"
                    name="author"
                    disabled="disabled"
                    value="{{ $ticket->author->name }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            <div class="flex items-center">
                <label class="mr-2 w-1/3"
                       for="created_at"
                >Created:</label>
                <input
                    type="text"
                    id="created_at"
                    name="created_at"
                    disabled="disabled"
                    value="{{ $ticket->created_at }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            <div class="flex items-center">
                <label class="mr-2 w-1/4"
                       for="state"
                >State:</label>
                <input
                    type="text"
                    id="state"
                    name="state"
                    disabled="disabled"
                    value="{{ Ticket::getStateAsUserFriendlyString($ticket->state) }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            @if ($ticket->created_at != $ticket->updated_at)
            <div class="flex items-center">
                <label class="mr-2 w-1/3"
                       for="updated_at"
                >Updated:</label>
                <input
                    type="text"
                    id="updated_at"
                    name="updated_at"
                    disabled="disabled"
                    value="{{ $ticket->updated_at }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            @endif
        </div>

        <!--Description-->
        @include('common.ticket_request_description', ['label_text' => 'Description:', 'description' => $ticket->description])

        <!--Photos-->
        @include('common.ticket_request_photos', ['label_text' => 'Photo attachments:', 'photos' => $ticket->photo_attachments])

        <!--Comments-->
        @include('common.ticket_request_comments', ['comments' => $comments, 'ticket_request' => $ticket])

    </div>
</x-app-layout>
