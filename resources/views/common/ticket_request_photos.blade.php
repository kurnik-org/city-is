<div class="mt-4">
    <label
        for="photo_attachments"
    >Photo attachments:</label>
    <div id="photo_attachments">
        <div class="mt-1 bg-white shadow-sm rounded-lg divide-y">
            <!--TODO: Add image preview-->
            @foreach ($photos as $photo)
                <div class="p-3 flex space-x-2">
                    <a
                        class="text-blue-500 underline hover:text-blue-700"
                        href="{{ Storage::url($photo->filepath) }}"
                        target="_blank">
                        {{ pathinfo($photo->filepath, PATHINFO_BASENAME) }}
                    </a>
                </div>
            @endforeach
        </div>
        @if (count($photos) == 0)
            <p>No photos uploaded.</p>
        @endif
    </div>
</div>
