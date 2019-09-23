@if(session('flash_message'))
    <div class="alert alert-info auto-collapse">
        {!! session('flash_message') !!}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@endif
@if (session('status'))
    <div class="alert alert-success auto-collapse">
        {{ session('status') }}
    </div>
@endif
@if($envelopeNegative == true && $grandBalance < 0)
    <div class="alert alert-danger">
        Cuidado! Seu saldo está negativo. Você possui um ou mais envelopes com saldo negativo.<br>
        <small>Isso quer dizer que você gastou mais do que tinha somando todos os seus recursos.</small>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@elseif($envelopeNegative == true && $grandBalance > 0)
    <div class="alert alert-warning">
        Você possiu um ou mais envelopes com saldo negativo. <br>
        <small>Mas seu saldo ainda está positivo! Isso significa que você tem saldo suficiente outros envelopes que cobriram suas desepsas.</small>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@elseif($envelopeNegative == false && $grandBalance < 0)
    <div class="alert alert-danger">
        Cuidado! Seu saldo está negativo.
        <small>Isso quer dizer que você gastou mais do que tinha somando todos os seus recursos.</small>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
@endif