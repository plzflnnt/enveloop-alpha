<div class="envelope-group">
    &nbsp;
    <div class="row">
        <div class="col">
            @include('abas.modal.add-envelope')
        </div>
    </div>
    &nbsp;
    <div class="row">
        <div class="col-12 col-sm-4">
            <button class="btn btn-outline-primary btn-sm btn-block" disabled>Saldo: <strong
                        style="color: <?= ($balance <= 0) ? '#dc3545' : '#28a745' ?>">R$ {{ $balance }}</strong>
            </button>
        </div>
        @foreach($envelopes as $envelope)
            <div class="col-12 col-sm-4">
                <button class="btn btn-outline-primary btn-sm btn-block" disabled>{{ $envelope->name }}:
                    <strong style="color: <?= ($envelope->balance <= 0) ? '#dc3545' : '#28a745' ?>">R$: {{ $envelope->balance }}</strong>
                </button>
            </div>
        @endforeach
        @if(count($envelopes) == 0)
            <div class="col-12 col-sm-4">
                <button class="btn btn-outline-info btn-sm btn-block" disabled>Você não possui envelopes ainda!</button>
            </div>
        @endif

    </div>
</div>
&nbsp;
<hr>
&nbsp;
<div class="feed-group">
    <div class="row">
        <div class="col">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                @foreach($feed as $item)
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
                        $color = "#28a745";
                    }elseif($item->type ==  2){
                        $color = "#28a745";
                    }elseif($item->type ==  3){
                        $color = "#dc3545";
                    }elseif($item->type ==  4){
                        $color = "#dc3545";
                    }
                    date_default_timezone_set('America/Sao_Paulo');
                    ?>
                    <tr>
                        <td><i class="fa {{ $style }}" style="color: {{ $color }}"></i>
                            &nbsp;R$ {{ \App\Envelope::formatCurrency($item->value) }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->envelope }}</td>
                        <td>{{ date('d/m/y H:i', strtotime($item->updated_at)) }}</td>
                    </tr>
                @endforeach
                @if(count($feed) == 0)
                    <tr>
                        <td colspan="3" class="text-center">Tudo tão silêncioso por aqui 🌚</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $feed->links() }}
        </div>
    </div>
</div>
<div class="graphic-group">
    <div class="row">
        @foreach($reportOne as $envelope)
        <div class="col-12 col-sm-6 col-md-4">
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
                        $color = "#28a745";
                    }elseif($item->type ==  2){
                        $color = "#28a745";
                    }elseif($item->type ==  3){
                        $color = "#dc3545";
                    }elseif($item->type ==  4){
                        $color = "#dc3545";
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
                </tbody>
            </table>
            <div class="progress">

                <?
                    $percentbalance = ($envelope->balance * 100) / ($envelope->balance + $shortHistorySpent);
                    $percentspent = ($shortHistorySpent * 100) / ($envelope->balance + $shortHistorySpent)
                ?>

                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentspent }}%" aria-valuenow="{{ $percentspent }}" aria-valuemin="0" aria-valuemax="100">{{ \App\Envelope::formatCurrency($shortHistorySpent) }}</div>
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentbalance }}%" aria-valuenow="{{ $percentbalance }}" aria-valuemin="0" aria-valuemax="100">{{ \App\Envelope::formatCurrency($envelope->balance) }}</div>
            </div>
            <br>
        </div>
        @endforeach
    </div>
</div>

