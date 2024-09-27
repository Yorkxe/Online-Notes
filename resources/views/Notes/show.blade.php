<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a href="{{ route('Notes.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    <- Go back
                </a>
                <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Creator</th>
                        <th class="px-4 py-2 border">Subject</th>
                        <th class="px-4 py-2 border">Views</th>
                        <th class="px-4 py-2 border">Created Time</th>
                        <th class="px-4 py-2 border">Last Updated Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border">{{ $Notes['creator']->name }}</td>
                        <td class="px-4 py-2 border">{{ $Notes['Subject'] }}</td>
                        <td class="px-4 py-2 border">{{ $Notes['Views'] }}</td>
                        <td class="px-4 py-2 border">{{ $Notes['created_at'] }}</td>
                        <td class="px-4 py-2 border">{{ $Notes['updated_at'] }}</td>
                    </tr>
                </tbody>
            </table>
                
            </div>
        </div>
        <div class="text-center" style="margin:5%">
            {{$Content}}
        <div>
    </div>
</x-app-layout>