<div class="mt-4">
    <label
        for="comments"
    >Comments:</label>
    <div id="comments">
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf
            <textarea
                name="text"
                placeholder="{{ __('Tell us more...') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('text') }}</textarea>
            <x-input-error :messages="$errors->get('text')" class="mt-2"/>
            <input type="hidden" name="commentable_id" value="{{ $ticket_request->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($ticket_request) }}">
            <input type="hidden" name="author_id" value="{{ Auth::user()->id }}">
            <x-primary-button name="submit-comments" class="mt-0.5">{{ __('Comment') }}</x-primary-button>
        </form>
        <div class="mt-1 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($comments as $comment)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <!--TODO: Distinguish author of the text according to the role?-->
                                <span class="text-gray-800">{{ $comment->author->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('j M Y, g:i a') }}</small>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-900">{{ $comment->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @empty ($comments)
            <p>No comments yet...</p>
        @endempty
    </div>
</div>
