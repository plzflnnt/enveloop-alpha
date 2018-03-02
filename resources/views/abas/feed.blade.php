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
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($feed as $item)
                    <tr>
                        <td>{{ $item->updated_at }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->envelope }}</td>
                        <td><i class="fa fa-arrow-up" style="color: #28a745"></i> &nbsp;{{ \App\Envelope::formatCurrency($item->value) }}</td>
                    </tr>
                @endforeach
                @if(count($feed) == 0)
                    <tr>
                        <td colspan="3" class="text-center">Tudo tão silêncioso por aqui 🌚</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

