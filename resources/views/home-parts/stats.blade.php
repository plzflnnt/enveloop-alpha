<div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2">
            <p>Gastos e ganhos dos últimos meses</p>
            <canvas id="chart-months"></canvas>
        </div>
</div>

<script>
        var ctx = document.getElementById("chart-months").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($report as $data)
                    {{ $data["month"] }},
                    @endforeach
                ],
                datasets: [{
                    label: 'Ganho',
                    data: [
                        @foreach($report as $data)
                        {{ $data["earn"]/100 }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(1, 255, 1, 0.2)',
                        'rgba(1, 255, 1, 0.2)',
                        'rgba(1, 255, 1, 0.2)',
                        'rgba(1, 255, 1, 0.2)',
                        'rgba(1, 255, 1, 0.2)',
                    ],
                    borderColor: [
                        'rgba(1, 255, 1, 1)',
                        'rgba(1, 255, 1, 1)',
                        'rgba(1, 255, 1, 1)',
                        'rgba(1, 255, 1, 1)',
                        'rgba(1, 255, 1, 1)',
                    ],
                    borderWidth: 1
                }, {
                    label: 'Gasto',
                    data: [
                        @foreach($report as $data)
                        {{ $data["spent"]/100 }},
                        @endforeach
                        ],
                    backgroundColor: [
                        'rgba(255, 1, 1, 0.2)',
                        'rgba(255, 1, 1, 0.2)',
                        'rgba(255, 1, 1, 0.2)',
                        'rgba(255, 1, 1, 0.2)',
                        'rgba(255, 1, 1, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 1, 1, 1)',
                        'rgba(255, 1, 1, 1)',
                        'rgba(255, 1, 1, 1)',
                        'rgba(255, 1, 1, 1)',
                        'rgba(255, 1, 1, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
</script>
