<div class="envelope-group">
    &nbsp;
    <div class="row">
        <div class="col">
            @include('abas.modal.add-earning-to-balance')
        </div>
    </div>

    &nbsp;
    <div class="row">

        @if(count($envelopes) == 0)
            <div class="col-12 col-sm-4">
                <button class="btn btn-outline-info btn-sm btn-block" disabled>Nenhum envelope criado ainda!</button>
            </div>
        @endif
        @foreach($envelopes as $envelope)
            <div class="col-12 col-sm-4">
                <button class="btn btn-outline-primary btn-sm btn-block" disabled>{{ $envelope->name }}:
                    <strong style="color: <?= ($envelope->balance <= 0) ? '#f2756a' : '#89e17a' ?>">R$: {{ $envelope->balance }}</strong>
                </button>
            </div>
        @endforeach
            @include('abas.modal.add-envelope')


    </div>
</div>
&nbsp;
<hr>
&nbsp;
<div class="graphic-group">
    <p><small>Últimos 30 dias</small></p>

    <div class="row">
        @foreach($reportOne as $envelope)
        <div class="col-12 col-sm-6 col-md-4 envelope-color-{{ $envelope->style }}">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" colspan="3">{{ $envelope->name }}</th>
                </tr>
                </thead>
                <tbody>
                <?
                    $shortHistory = \App\Feed::shortHistory($envelope->id);
                    $shortHistorySpent = \App\Feed::shortHistoryExpenses($envelope->id)
                ?>
                @foreach($shortHistory as $item)
                    <?
                    $style = "";
                    if($item->type == 1 ){
                        $style = "fa-arrow-up";
                    }elseif($item->type == 2 ){
                        $style = "fa-arrow-up";
                    }elseif($item->type == 4){
                        $style = "fa-arrow-down";
                    }elseif($item->type == 3 ){
                        $style = "fa-arrow-down";
                    }
                    $color = "";
                    if($item->type == 1 ) {
                        $color = "#89e17a";
                    }elseif($item->type ==  2){
                        $color = "#89e17a";
                    }elseif($item->type ==  3){
                        $color = "#f2756a";
                    }elseif($item->type ==  4){
                        $color = "#f2756a";
                    }
                    date_default_timezone_set('America/Sao_Paulo');
                    ?>
                    <tr>
                        <th scope="row"  data-toggle="tooltip" data-placement="top" title="{{ $item->name }}">
                            <i class="fa {{ $style }}" style="color: {{ $color }}"></i>
                            &nbsp;R$ {{ \App\Envelope::formatCurrency($item->value) }}
                        </th>
                        <td>{{ date('d/m', strtotime($item->updated_at)) }}</td>
                    </tr>
                @endforeach
                @if(count($shortHistory)==2)
                    <tr>
                        <th colspan="2" style="height: 28px"></th>
                    </tr>
                @endif
                @if(count($shortHistory)==0)
                    <tr>
                        <th colspan="2" style="height: 84px">Opa! Nenhuma transação recente</th>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="progress">

                <?
                    $percentbalance = ($envelope->balance * 100) / ($envelope->balance + $shortHistorySpent);
                    $percentspent = ($shortHistorySpent * 100) / ($envelope->balance + $shortHistorySpent)
                ?>

                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentspent }}%" aria-valuenow="{{ $percentspent }}" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="R$ {{ \App\Envelope::formatCurrency($shortHistorySpent) }}">{{ \App\Envelope::formatCurrency($shortHistorySpent) }}</div>
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentbalance }}%" aria-valuenow="{{ $percentbalance }}" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="R$ {{ \App\Envelope::formatCurrency($envelope->balance) }}">{{ \App\Envelope::formatCurrency($envelope->balance) }}</div>
            </div>
            <br>
        </div>
        @endforeach
    </div>
</div>

