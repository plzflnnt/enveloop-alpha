<div class="envelope-group">
    &nbsp;
    <div class="row">
        <div class="col">
            @include('abas.modal.add-envelope')
        </div>
    </div>
    &nbsp;
    <div class="row">
        <div class="col-12 col-sm-4"><button class="btn btn-outline-primary btn-sm btn-block" disabled>Saldo: <strong>R$ {{ $user->balance }}</strong></button></div>
        @foreach($envelopes as $envelope)
            <div class="col-12 col-sm-4"><button class="btn btn-outline-primary btn-sm btn-block" disabled>{{ $envelope->name }}: <strong>R$: {{ $envelope->balance }}</strong></button></div>
        @endforeach
        @if(count($envelopes) == 0)
            <div class="col-12 col-sm-4"><button class="btn btn-outline-info btn-sm btn-block" disabled>Você não possui envelopes ainda!</button></div>
        @endif

    </div>
</div>

