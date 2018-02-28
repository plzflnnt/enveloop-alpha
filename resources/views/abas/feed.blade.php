<div class="envelope-group">
    &nbsp;
    <div class="row">
        <div class="col">
            @include('abas.modal.add-envelope')
        </div>
    </div>
    &nbsp;
    <div class="row">
        <div class="col-12 col-sm-4"><button class="btn btn-outline-primary btn-sm btn-block" disabled>Saldo <span class="right">{{ $user->balance }}</span></button></div>
        @foreach($envelopes as $envelope)
            <div class="col-12 col-sm-4"><button class="btn btn-outline-primary btn-sm btn-block" disabled>{{ $envelope->name }}</button></div>
        @endforeach
    </div>
</div>

