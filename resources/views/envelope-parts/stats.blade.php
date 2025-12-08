<hr>
<div class="row mt-4">
    <div class="col-12 mt-4">
        <h3>Gastos/Ganhos</h3>
        <canvas id="chart-months-envelope"></canvas>
    </div>
    <div class="col-12 mt-4">
        <h3>Resultados do mês</h3>
        <canvas id="chart-difference"></canvas>
    </div>
    <div class="col-12 mt-4">
        <h3>Progressão do saldo</h3>
        <canvas id="chart-progression"></canvas>
    </div>
    <div class="col-12" style="display:none">
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
                    <td style="color: <?= ($data["balanceProgression"] <= 0) ? '#f2756a' : '#28a745' ?>">R$ {{ App\Envelope::formatCurrency($data["balanceProgression"]) }}</td>
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
</div>

<script>
    var ctx = document.getElementById("chart-months-envelope").getContext('2d');
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
                    @foreach($report as $data)
                        'rgba(1, 255, 1, 0.2)',
                    @endforeach
                ],
                borderColor: [
                    @foreach($report as $data)
                        'rgba(1, 255, 1, 1)',
                    @endforeach
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
                    @foreach($report as $data)
                        'rgba(255, 1, 1, 0.2)',
                    @endforeach
                ],
                borderColor: [
                    @foreach($report as $data)
                        'rgba(255, 1, 1, 1)',
                    @endforeach
                ],
                borderWidth: 1
            },
                    <?
                    $media = 0;
                    foreach ($report as $data){
                        $media += $data["earn"];
                    }
                    ?>
                {
                    label: 'Média de Investimento',
                    data: [
                        @foreach($report as $data)
                        {{$media/1200}},
                        @endforeach
                    ],
                    borderColor:'rgba(1, 255, 1, 1)',
                        backgroundColor:'rgba(1, 255, 1, 0)',

                    // Changes this dataset to become a line
                    type: 'line'
                },


                    <?
                    $media = 0;
                    foreach ($report as $data){
                        $media += $data["spent"];
                    }
                    ?>

                {
                    label: 'Média de Gasto',
                    data: [
                        @foreach($report as $data)
                        {{$media/1200}},
                        @endforeach
                    ],
                    borderColor:'rgba(255, 1, 1, 1)',
                        backgroundColor:'rgba(1, 255, 1, 0)',

                    // Changes this dataset to become a line
                    type: 'line'
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
    var dff = document.getElementById("chart-difference").getContext('2d');
    var difference = new Chart(dff, {
        type: 'bar',
        data: {
            labels: [
                @foreach($report as $data)
                {{ $data["month"] }},
                @endforeach
            ],
            datasets: [{
                label: 'Diferença',
                data: [
                    @foreach($report as $data)
                    {{ ($data["earn"]-$data["spent"])/100 }},
                    @endforeach
                ],
                backgroundColor: [
                    @foreach($report as $data)
                            @if(($data["earn"]-$data["spent"])/100 < 0)
                        'rgba(255, 1, 1, 0.2)',
                    @else
                        'rgba(1, 255, 1, 0.2)',
                    @endif
                    @endforeach
                ],
                borderColor: [
                    @foreach($report as $data)
                            @if(($data["earn"]-$data["spent"])/100 < 0)
                        'rgba(255, 1, 1, 1)',
                    @else
                        'rgba(1, 255, 1, 1)',
                    @endif
                    @endforeach
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
            },
            elements: {
                line: {
                    tension: 0
                }
            }
        }
    });

    var prgrssn = document.getElementById("chart-progression").getContext('2d');
    var progression = new Chart(prgrssn, {
        type: 'line',
        data: {
            labels: [
                @foreach($report as $data)
                {{ $data["month"] }},
                @endforeach
            ],
            datasets: [{
                label: 'Progressão',
                data: [
                    @foreach($report as $data)
                    {{ $data["balanceProgression"]/100 }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
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
            },
            elements: {
                line: {
                    tension: 0
                }
            }
        }
    });
</script>
