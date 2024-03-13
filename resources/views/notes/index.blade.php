<x-app-layout>
    <div class="note-container">
        <a href="{{ route('notes.create') }}" class="new-note-btn">New note</a>
        <div class="notes">
            @foreach ($notes as $note)
                <div class="note">
                    <div class="note-body">
                        <p>{{ Str::words($note->note, 30) }}</p>
                    </div>
                    <div class="note-buttons">
                        <a href="{{ route('notes.show', $note) }}" class="note-view-button">View</a>
                        <a href="{{ route('notes.edit', $note) }}" class="note-edit-button">Edit</a>
                        <button class="note-delete-button">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $notes->links() }}
    </div>
</x-app-layout>
