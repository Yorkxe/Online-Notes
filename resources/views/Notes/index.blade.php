<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if(Auth::User()->authority < 3)
                <a href="{{ route('Notes.create') }}"
                   class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                   Create a New Note
                </a>
                @endif

                @if ($message = Session::get('success'))
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ $message }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ $errors->first() }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <table class="w-full table-fixed">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Creator</th>
                            <th class="px-4 py-2 border">Subject</th>
                            <th class="px-4 py-2 border">Views</th>
                            <th class="px-4 py-2 border">Create Time</th>
                            <th class="px-4 py-2 border">Update Time</th>
                            <th class="px-4 py-2 border">Move</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($Notes))
                            @foreach($Notes as $row)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $row->User->name }}</td>
                                    <td class="px-4 py-2 border">{{ $row->Subject }}</td>
                                    <td class="px-4 py-2 border">{{ $row->Views }}</td>
                                    <td class="px-4 py-2 border">{{ $row->created_at }}</td>
                                    <td class="px-4 py-2 border">{{ $row->updated_at }}</td>
                                    <td class="px-4 py-2 border">
                                        <form action="{{ route('Notes.destroy', $row->id) }}" method="POST">
                                            <a href="{{ route('Notes.show', $row->id) }}" class="inline-flex items-center px-4 py-2 mx-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                                                Show
                                            </a>
                                            @if($row->user == Auth::User())
                                            <a href="{{ route('Notes.edit', $row->id) }}" class="inline-flex items-center px-4 py-2 mx-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                                                Edit
                                            </a>
                                            @endif
                                            @csrf
                                            @if($row->user == Auth::User())
                                                @method('DELETE')
                                                <button type="submit" title="delete" class="inline-flex items-center px-4 py-2 mx-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-gray disabled:opacity-25">
                                                    Delete
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="px-4 py-2 border text-red-500" colspan="3">No Notes found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
