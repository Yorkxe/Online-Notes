<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a href="{{ route('Notes.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    <- Go back
                </a>
                <form action="{{ route('Notes.store') }}" method="POST" class="text-center">
                    @csrf
                    <div class="mb-4">
                        <label for="textSubject"
                            class="text-center  text-sm font-bold text-gray-700">Subject</label>
                        <input type="text"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            name="Subject"
                            placeholder="It's hard to take a summary for your great idea.">
                        @error('name') <span class="text-red-500">{{ $message }}
                        </span>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="texteContent"
                            class="block mb-2 text-sm font-bold text-gray-700">Content</label>
                        <textarea
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            name="Content"
                            placeholder="Write sth amazing">
                        @error('Content') <span class="text-red-500">{{ $Content }}
                        </span>@enderror
                        </textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit"
                        class="inline-flex items- px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
