@if(count($envelopes) != 0)
    &nbsp
    <div class="row">
        <div class="col-12 mt-4">
            <h2>Estatísticas</h2>
        </div>
        <div class="col-12 mt-4">
            <h3>Gastos/Ganhos</h3>
            <canvas id="chart-months"></canvas>
        </div>
        <div class="col-12 mt-4">
            <h3>Resultados do mês</h3>
            <canvas id="chart-difference"></canvas>
        </div>
        <div class="col-12 mt-4">
            <h3>Progressão do saldo</h3>
            <canvas id="chart-progression"></canvas>
        </div>
        <div class="col-12 mt-4">
            <h3>Divisão do dinheiro</h3>
            <canvas id="chart-env-division"></canvas>
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
        {{--<div class="col-12">--}}
            {{--<p class="text-center mt-3"><a href="{{ url('report') }}" class="btn btn-outline-primary">Relatórios</a></p>--}}
        {{--</div>--}}


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
                    }
                ]
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


        var evdv = document.getElementById("chart-env-division").getContext('2d');
        var envDivision = new Chart(evdv, {
            type: 'pie',
            data: {
                labels: [
                    'Saldo não alocado',
                    @foreach($envelopes as $envelope)
                    '{{ $envelope->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Progressão',
                    data: [
                        {{ \App\Envelope::formatNumber($balance)/100 }},
                        @foreach($envelopes as $envelope)
                        {{ \App\Envelope::formatNumber($envelope->balance)/100 }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
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
@endif