<!--Admin can edit Technician-->
<!--Technician can edit State, Costs, Exp. date, Notes-->

<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('service_requests.update', $sr->id) }}">
            @csrf
            @method('patch')
            <!--Heading-->
            <h1
                class="text-3xl text-center"
            >Editing Service request #{{ $sr->id }}</h1>
            <h2
                class="text-2xl text-center"
            >{{ $sr->title }}</h2>

            <!--Author, date, state, requests-->
            <div class="mt-4 grid grid-cols-2 gap-4">
                @if (Auth::user()->getRole() != User::getRoleId('technician'))
                <div class="flex items-center">
                    <label
                        for="technician_id"
                        class="mr-2 w-1/2"
                    >Technician:</label>
                    <select
                        name="technician_id"
                        id="technician_id"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20">
                        @foreach (User::where('role_id', User::getRoleId('technician'))->get() as $technician)
                            <option value="{{ $technician->id }}" <?php echo ($technician->id == $sr->technician_id)?"selected":""; ?>>#{{ $technician->id }}: {{ $technician->name }} </option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="flex items-center">
                    <label
                        for="state"
                        class="mr-2 w-1/2"
                    >State:</label>
                    <select
                        name="state"
                        id="state"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20">
                        <option value="0" <?php echo ($sr->state == 0)?"selected":""; ?>>{{ ServiceRequest::getStateAsUserFriendlyString(0) }}</option>
                        <option value="1" <?php echo ($sr->state == 1)?"selected":""; ?>>{{ ServiceRequest::getStateAsUserFriendlyString(1) }}</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <label class="mr-2 w-1/3"
                           for="costs"
                    >Costs:</label>
                    <span style="padding-right:4px">$</span>
                    <input
                        type="number"
                        step=".01"
                        min="0"
                        id="costs"
                        name="costs"
                        @if (is_null($sr->costs_usd))
                            value=""
                        @else
                            value="{{ $sr->costs_usd }}"
                        @endif
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                    />
                </div>
                <div class="flex items-center">
                    <label class="mr-2 w-1/2"
                           for="expected_date"
                    >Exp. date:</label>
                    <input
                        type="date"
                        id="expected_date"
                        name="expected_date"
                        min="{{ date('Y-m-d') }}"
                        @if (is_null($sr->expected_date_of_resolution))
                            value=""
                        @else
                            value="{{ $sr->expected_date_of_resolution }}"
                        @endif
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-shrink-20"
                    />
                </div>
                @endif
            </div>
            <x-input-error :messages="$errors->get('technician_id')" class="mt-2" />
            <x-input-error :messages="$errors->get('state')" class="mt-2" />
            <x-input-error :messages="$errors->get('costs')" class="mt-2" />
            <x-input-error :messages="$errors->get('expected_date')" class="mt-2" />

            <div class="mt-4">
                <label
                    for="notes"
                >Notes:</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="6"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ $sr->notes }}</textarea>
            </div>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('service_requests.show', $sr->id) }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
