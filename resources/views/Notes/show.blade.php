<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a href="{{ route('Notes.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    <- Go back
                </a>
                <table class="w-full table-fixed">
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 font-bold">Creator</td>
                            <td>{{ $Notes->User->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-bold">Subject</td>
                            <td>{{ $Notes->Subject }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-bold">Views</td>
                            <td>{{ $Notes->Views }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-bold">Created Time</td>
                            <td>{{ $Notes->created_at }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-bold">Last updated</td>
                            <td>{{ $Notes->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    {{$Content}}
                <div>
            </div>
        </div>
    </div>
</x-app-layout>