<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <!--Heading-->
        <h1
            class="text-3xl text-center"
        >Service request #{{ $sr->id }}</h1>
        <h2
            class="text-2xl text-center"
        >{{ $sr->title }}</h2>

        <!--Button to the original ticket-->
        <!--TODO: Center text-->
        <div class="mt-4 grid grid-cols-2 gap-4">
            <a href="{{ route('tickets.show', $sr->ticket_id) }}">
                <x-primary-button class="w-full">Go to the original ticket</x-primary-button>
            </a>
            @if ($sr->technician_id == Auth::user()->id || in_array(Auth::user()->getRole(), [User::getRoleId('admin'), User::getRoleId('city_admin')]))
            <a href="{{ route('service_requests.edit', $sr->id) }}">
                <x-primary-button class="w-full">Update service request</x-primary-button>
            </a>
            @endif
        </div>

        <!--Author, date, state, requests-->
        <div class="mt-4 grid grid-cols-2 gap-4">
            <div class="flex items-center">
                <label class="mr-2 w-1/2"
                       for="technician"
                >Technician:</label>
                <input
                    type="text"
                    id="technician"
                    name="technician"
                    disabled="disabled"
                    value="{{ "#".$sr->technician->id.": ".$sr->technician->name }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            <div class="flex items-center">
                <label class="mr-2 w-1/2"
                       for="created_at"
                >Created:</label>
                <input
                    type="text"
                    id="created_at"
                    name="created_at"
                    disabled="disabled"
                    value="{{ $sr->created_at }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            <div class="flex items-center">
                <label class="mr-2 w-1/2"
                       for="state"
                >State:</label>
                <input
                    type="text"
                    id="state"
                    name="state"
                    disabled="disabled"
                    value="{{ $sr->getState()->user_friendly_string() }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            @if ($sr->created_at != $sr->updated_at)
            <div class="flex items-center">
                <label class="mr-2 w-1/2"
                       for="updated_at"
                >Updated:</label>
                <input
                    type="text"
                    id="updated_at"
                    name="updated_at"
                    disabled="disabled"
                    value="{{ $sr->updated_at }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            @else
            <!--Space for the updated_at div-->
            <div></div>
            @endif
            <div class="flex items-center">
                <label class="mr-2 w-1/2"
                       for="costs"
                >Costs:</label>
                <input
                    type="text"
                    id="costs"
                    name="costs"
                    disabled="disabled"
                    @if (is_null($sr->costs_usd))
                    value="Not specified"
                    @else
                    value="{{ '$' . number_format($sr->costs_usd, 2) }}"
                    @endif
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
            <div class="flex items-center">
                <label class="mr-2 w-1/2"
                       for="expected_date"
                >Exp. date:</label>
                <input
                    type="text"
                    id="expected_date"
                    name="expected_date"
                    disabled="disabled"
                    @if (is_null($sr->expected_date_of_resolution))
                    value="Not specified"
                    @else
                    value="{{ $sr->expected_date_of_resolution }}"
                    @endif
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                />
            </div>
        </div>

        <div class="mt-4">
            <label
                for="notes"
            >Notes:</label>
            <textarea
                id="notes"
                name="notes"
                rows="6"
                disabled="disabled"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ $sr->notes }}</textarea>
        </div>

        <!--Description-->
        @include('common.ticket_request_description', ['label_text' => 'Original ticket content:', 'description' => $sr->ticket->title."\n-----\n".$sr->ticket->description])

        <!--Photos-->
        @include('common.ticket_request_photos', ['label_text' => 'Photo attachments:', 'photos' => $sr->ticket->photo_attachments])

        <!--Comments-->
        @include('common.ticket_request_comments', ['comments' => $comments, 'ticket_request' => $sr])

    </div>
</x-app-layout>
