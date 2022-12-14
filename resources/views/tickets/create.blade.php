<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
            @csrf

            <!--Heading-->
            <h1
                class="text-3xl text-center"
            >Report an issue</h1>

            <!--Title-->
            <div class="mt-4">
                <label
                    for="title"
                    >Title:</label>
                @include('common.required_asterisk')
                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="{{ __('What\'s the problem?') }}"
                    value="{{ old('title') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!--Description-->
            <div class="mt-4">
                <label
                    for="description"
                >Description:</label>
                @include('common.required_asterisk')
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="{{ __('Describe the problem...') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!--Photo attachments-->
            <div class="mt-4">
                <label
                    for="photo_attachments"
                >Photo attachments:</label>
                <input
                    type="file"
                    id="photo_attachments"
                    name="photo_attachments[]"
                    accept="image/jpeg"
                    class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    multiple
                >
            </div>

            @include('common.required_description')

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Report') }}</x-primary-button>
                <a href="{{ route('tickets.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
