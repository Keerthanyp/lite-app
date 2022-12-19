<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- to display error messages --}}
            {{-- @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach --}}

            <div class="my-6 p-6 bg-white border-b border-grat-200 shadow-sm sm:rounded-lg">
                <form action="{{ route('notes.store') }}" method="POST">
                    @csrf
                    <x-text-input type="text" field="title" name="title" class="w-full" autocomplete="off"
                        placeholder="Title" :value="@old('title')">
                    </x-text-input>
                    {{--  :value="@old('title')" is used to parse the value to component--}}
                    {{-- accessing the error component by specifying the prop field value --}}
                    <x-textarea name="text" field="text" id="text" cols="30" rows="10"
                        placeholder="Start typing here..." :value="@old('text')" class="w-full"></x-textarea>
                    <x-primary-button class="mt-6">Save Note</x-primary-button>
                </form>
            </div>
        </div>
</x-app-layout>
