<div class="envelope-group">
    &nbsp;
    <div class="row">
        <div class="col mb-4">
            @include('home-parts.modal.balance')
        </div>
    </div>
    <hr>
    <div class="row mt-5">
        @if(count($envelopes) == 0)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Sem envelopes ainda</h5>
                        <h6 class="card-subtitle mb-2" style="color: #f2756a">R$: 0,00</h6>
                    </div>
                </div>
            </div>
        @endif
        @foreach($envelopes as $envelope)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ url("envelope/".encrypt($envelope->id)) }}"
                                                  class="text-dark">{{ $envelope->name }}</a></h5>
                        <h6 class="card-subtitle mb-2"
                            style="color: <?= ($envelope->balance <= 0) ? '#f2756a' : '#89e17a' ?>">
                            R$: {{ $envelope->balance }}</h6>
                        @include('home-parts.modal.envelope-actions')
                    </div>
                </div>
            </div>
        @endforeach
        @include('home-parts.modal.add-envelope')
    </div>
</div>
&nbsp;
@if(count($envelopes) == 0)
    <div class="col-12">
        <p><strong>Bem-vindo ao Enveloop!</strong> Para começar clique em investir (ao lado do Saldo) e insira o seu
            saldo atual somado de todas as suas economias, após isso é hora de criar um envelope.</p>
        <p>Se você não sabe o que é o método dos envelopes <a href="" target="_blank">clique aqui</a> e assista um curto
            vídeo explicativo.</p>
        <p>Cada envelope serve como uma poupança onde você pode dividir deu dinheiro por tipo de gasto e organizar suas
            finanças evitando que você use o dinheiro do seguro do carro com as saídas no fim de semana por exemplo.</p>
        <p>Tendo um maior controle visual sobre suas finanças, você junta dinheiro pra comprar aquele celular bacana no
            fim do ano sem faltar dinheiro para as coisas essenciais</p>
    </div>
    &nbsp;
    <hr>
    &nbsp;
@endif
@include('home-parts.transactions')
@if(count($envelopes) != 0)
    <hr>
    &nbsp;
    @include('home-parts.stats')
    <hr>

    <?
    $totalSum = 0;
    $totalSum = \App\Envelope::formatNumber($balance);

    foreach ($envelopes as $envelope) {
        $x = \App\Envelope::formatNumber($envelope->balance);
        $totalSum += $x;
    }
    ?>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><span
                            style="color: <?= ($totalSum <= 0) ? '#f2756a' : '#89e17a' ?>">R$ {{ \App\Envelope::formatCurrency($totalSum) }}</span>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">Este é o total de dinheiro que deve ter em suas mãos</h6>
            </div>
        </div>
    </div>
@endif

