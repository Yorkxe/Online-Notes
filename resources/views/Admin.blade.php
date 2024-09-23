<x-app-layout>
<div class="container-fluid px-4">
        <h2 class="mt-4" style="font-size: 35px;font-weight: 600;">Last Five Weeks' Notes</h1>
        <canvas id="History_Notes"></canvas>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Area Chart Example
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Top Doctors
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Speciality</th>
                        <th>Room No</th>
                        <th>Fees</th>
                        <th>Image</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    const chartElement = document.getElementById('History_Notes').getContext("2d");
    
    new Chart(chartElement, {
    type: 'bar',
    data: {
        labels: ['第一個', '第二個', '第三個'],
        datasets: [{
            label: '我是種類',
            data: [1, 10, 5],
        }]
    }
    });
</script>

</x-app-layout>