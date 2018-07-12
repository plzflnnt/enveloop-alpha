<?
$totalSum = 0;
$totalSum = \App\Envelope::formatNumber($balance);

foreach ($envelopes as $envelope) {
    $x = \App\Envelope::formatNumber($envelope->balance);
    $totalSum += $x;
}
?>
&nbsp;
<p data-toggle="tooltip" data-placement="top"
    title="Essa deve ser a soma de todo seu dinheiro no momento, use essa informação para conferir se o valor está no Enveloop é o mesmo que você tem &quot;em mãos&quot;">
    Soma total de dinheiro: <span
            style="color: <?= ($totalSum <= 0) ? '#f2756a' : '#89e17a' ?>">R$ {{ \App\Envelope::formatCurrency($totalSum) }}</span>
</p>
<hr>
<div class="row">

    @foreach($reportMonthByMonth as $report)
        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            <p>{{ $report["name"] }}</p>
            <canvas id="chart-months-envelope-{{ $report["envelope_id"] }}" width="400" height="400"></canvas>
        </div>
    @endforeach
</div>

<script>
    @foreach($reportMonthByMonth as $report)
        var ctx = document.getElementById("chart-months-envelope-{{ $report['envelope_id'] }}").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($report["data"] as $data)
                    {{ $data["month"] }},
                    @endforeach
                ],
                datasets: [{
                    label: 'Ganho',
                    data: [
                        @foreach($report["data"] as $data)
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
                        @foreach($report["data"] as $data)
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
    @endforeach
</script>
