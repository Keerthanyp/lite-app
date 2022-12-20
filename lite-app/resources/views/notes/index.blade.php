<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->routeIs('notes.index') ? __('Notes') : __('Trash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("All Notes!") }}
                </div>
            </div> --}}

            <x-alert-success>
                {{ session('success') }}
            </x-alert-success>

            @if (request()->routeIs('notes.index'))
                <a href="{{ route('notes.create') }}" class="btn-link btn-lg mb-2">+ New Note</a>
            @endif

            {{-- retreiving the notes and displaying --}}
            {{-- @foreach ($notes as $note) --}}
            {{-- suppose there are no notes to display- thus use forelse --}}
            @forelse ($notes as $note)
                <div class="my-6 p-6 bg-white border-b border-grat-200 shadow-sm sm:rounded-lg">
                    <h2 class="font-bold text-3xl">
                        {{-- <a href="{{ route('notes.show', $note->uuid ) }}">{{ $note->title }}</a> --}}
                        <a
                            @if (request()->routeIs('notes.index')) href="{{ route('notes.show', $note) }}"
            @else
            href="{{ route('trashed.show', $note) }}" @endif>{{ $note->title }}</a>
                    </h2>
                    <p class="mt-2">
                        {{-- {{ $note->text }} #this would display even if the lengthy text is added thus add a string limit --}}
                        {{ Str::limit($note->text, 200) }} {{-- limiting the text to 200 characters --}}
                    </p>

                    {{-- the date is in carbon format, thus add diffForHumans function --}}
                    {{-- <span class="block mt-4 text-sm opacity-70">{{ $note->updated_at->diffForHumans() }}</span> --}}
                </div>
                {{-- @endforeach --}}
            @empty
                @if (request()->routeIs('notes.index'))
                    <p>No notes available</p>
                @else
                    <p>No items in the Trash</p>
                @endif
            @endforelse

            {{-- to display the pagination --}}
            {{ $notes->links() }}
        </div>
    </div>
</x-app-layout>
