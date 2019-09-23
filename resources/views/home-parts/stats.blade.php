@if(count($envelopes) != 0)
    &nbsp
    <div class="row">
        <div class="col-12">
            <h2>Estatísticas</h2>
        </div>
        <div class="col-12 col-lg-8">
            <canvas id="chart-months"></canvas>
        </div>
        <div class="col-12 col-lg-4">
            <table class="table table-striped">
                <thead class="">
                <tr>
                    <th>Mês</th>
                    <th>Saldo</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <? $earnings = 0 ?>
                @foreach($report as $data)

                    <tr>
                        <td>{{ $data["month"] }}</td>
                        <td style="color: <?= ($data["earn"]-$data["spent"] <= 0) ? '#f2756a' : '#28a745' ?>">R$ {{ App\Envelope::formatCurrency($data["earn"]-$data["spent"]) }}</td>
                        <td style="color: <?= ($data["historyBalance"] <= 0) ? '#f2756a' : '#28a745' ?>">R$ {{ App\Envelope::formatCurrency($data["historyBalance"]) }}</td>
                    </tr>
                    <? $earnings += $data["earn"]-$data["spent"]?>
                @endforeach
                <tr>
                    <td><strong>Total:</strong></td>
                    <td style="color: <?= ($earnings <= 0) ? '#f2756a' : '#28a745' ?>">R$ {{ App\Envelope::formatCurrency($earnings) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <p class="text-center mt-3"><a href="{{ url('report') }}" class="btn btn-outline-primary">Relatórios</a></p>
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
@endif