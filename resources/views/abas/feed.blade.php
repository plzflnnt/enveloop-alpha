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
                    ?>
                    <tr>
                        <td><i class="fa {{ $style }}" style="color: {{ $color }}"></i>
                            &nbsp;R$ {{ \App\Envelope::formatCurrency($item->value) }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->envelope }}</td>
                        <td>{{ date('d/m/y H:i'), strtotime($item->updated_at) }}</td>
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

