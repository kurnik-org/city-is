<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        @if (count($service_requests) == 0)
            <div class="pt-6">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pt-6 pb-6 text-xl text-gray-900 px-6 col-span-2">
                            No service requests to show.
                        </div>
                    </div>
                </div>
            </div>
        @else
            @foreach ($service_requests as $sr)
                @include('common.service_request_index_item', ['sr' => $sr])
            @endforeach
        @endif
        {{ $service_requests->links() }}
    </div>
</x-app-layout>
