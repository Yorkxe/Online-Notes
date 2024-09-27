<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
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
        </div>
        <!-- History_Notes -->
        <div>
            <h2 class="mt-4 text-center" style="font-size: 35px;font-weight: 600;">Last Five Months' Notes</h2>
            <div>
                <canvas id="History_Notes"></canvas>
            </div>
        </div>
        <!-- Users -->
        <div>
            <h2 class="text-center">Users</h2>
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">id</th>
                        <th class="px-4 py-2 border">name</th>
                        <th class="px-4 py-2 border">email</th>
                        <th class="px-4 py-2 border">authority</th>
                        <th class="px-4 py-2 border">created_at</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($Users))
                        @foreach($Users as $row)
                            <tr>
                                <td class="px-4 py-2 border">{{ $row->id }}</td>
                                <td class="px-4 py-2 border">{{ $row->name }}</td>
                                <td class="px-4 py-2 border">{{ $row->email }}</td>
                                <td class="px-4 py-2 border">{{ $row->authority }}</td>
                                <td class="px-4 py-2 border">{{ $row->created_at }}</td>
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
        <!-- Notes -->
        <div>
            <h2 class="text-center">Notes</h2>
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Creator</th>
                        <th class="px-4 py-2 border">Subject</th>
                        <th class="px-4 py-2 border">Views</th>
                        <th class="px-4 py-2 border">Create Time</th>
                        <th class="px-4 py-2 border">Update Time</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($Notes))
                        @foreach($Notes as $row)
                            <tr>
                                <td class="px-4 py-2 border">{{ $row->user_id }}</td>
                                <td class="px-4 py-2 border">{{ $row->Subject }}</td>
                                <td class="px-4 py-2 border">{{ $row->Views }}</td>
                                <td class="px-4 py-2 border">{{ $row->created_at }}</td>
                                <td class="px-4 py-2 border">{{ $row->updated_at }}</td>
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
        <!-- Users_History -->
        <div>
            <h2 class="text-center">Users_History</h2>
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">user_id</th>
                        <th class="px-4 py-2 border">Notes_id</th>
                        <th class="px-4 py-2 border">Move</th>
                        <th class="px-4 py-2 border">created_at</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($Users_History))
                        @foreach($Users_History as $row)
                            <tr>
                                <td class="px-4 py-2 border">{{ $row->user_id }}</td>
                                <td class="px-4 py-2 border">{{ $row->Notes_id}}</td>
                                <td class="px-4 py-2 border">{{ $row->Move }}</td>
                                <td class="px-4 py-2 border">{{ $row->created_at }}</td>
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
        <!-- Notes_History -->
        <div>
            <h2 class="text-center">Notes_History</h2>
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">id</th>
                        <th class="px-4 py-2 border">user_id</th>
                        <th class="px-4 py-2 border">Notes_id</th>
                        <th class="px-4 py-2 border">Move</th>
                        <th class="px-4 py-2 border">created_at</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($Notes_History))
                        @foreach($Notes_History as $row)
                            <tr>
                                <td class="px-4 py-2 border">{{ $row->id }}</td>
                                <td class="px-4 py-2 border">{{ $row->user_id }}</td>
                                <td class="px-4 py-2 border">{{ $row->Notes_id}}</td>
                                <td class="px-4 py-2 border">{{ $row->Move }}</td>
                                <td class="px-4 py-2 border">{{ $row->created_at }}</td>
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
<script>
    const chartElement = document.getElementById('History_Notes').getContext("2d");

    const month = ["January","February","March","April","May","June","July","August",
    "September","October","November","December"];
    //get the month of now
    const d = new Date();
    let Month_4 = month[d.getMonth() - 4];
    let Month_3 = month[d.getMonth() - 3];
    let Month_2 = month[d.getMonth() - 2];
    let Month_1 = month[d.getMonth() - 1];
    let Month_0 = month[d.getMonth()];

    // Amount of Notes from db
    var Notes_Amount = @json($Notes_Amount);

    new Chart(chartElement, {
    type: 'bar',
    data: {
        labels: [Month_4, Month_3, Month_2, Month_1, Month_0],
        datasets: [{
            label: 'Amount',
            data: Notes_Amount,
        }]
    },
    options:{
        // responsive: true,
        maintainAspectRatio: false,
        categoryPercentage: 0.4, // 分類比例
        barPercentage: 0.2 // 柱狀比例
    }
    });
    </script>
</div>
</x-app-layout>