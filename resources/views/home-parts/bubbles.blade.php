&nbsp;<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Saldo Não Alocado</h5>
                <h6 class="card-subtitle mb-2" style="color: <?= ($balance <= 0) ? '#f2756a' : '#28a745' ?>">
                    R$ {{ $balance }}</h6>
                <h6 class="card-subtitle mb-2 text-muted" title="Este saldo representa seus ganhos menos o dinheiro alocado nos envelopes. Note que isso não representa seu total em mãos!" data-placement="top" data-toggle="tooltip">O que é isso?</h6>
                <a data-toggle="modal" data-target="#balanceModalEarning"
                   class="card-link btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-up"></i>&nbsp;Ganho
                </a>
                <a data-toggle="modal" data-target="#balanceModalExpense"
                   class="card-link btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-down"></i>&nbsp;Despesa
                </a>
            </div>
        </div>
    </div>
    @include('home-parts.modal.balance')

    @if(count($envelopes) != 0)
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Saldo Em Mãos</h5>
                    <h6 class="card-subtitle mb-2"><span
                                style="color: <?= ($grandBalance <= 0) ? '#f2756a' : '#28a745' ?>">R$ {{ $grandBalance }}</span>
                    </h6>
                    <h6 class="card-subtitle mb-2 text-muted" title="Este é o total que você deve ter em mãos. É a soma do Seu SALDO NÃO ALOCADO e o Saldo dos Envelopes." data-placement="top" data-toggle="tooltip">O que é isso?</h6>
                </div>
            </div>
        </div>
    @endif
</div>


<div class="row">
    <div class="col-12">
        <h2>Envelopes</h2>
    </div>
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
                        style="color: <?= ($envelope->balance <= 0) ? '#f2756a' : '#28a745' ?>">
                        R$: {{ $envelope->balance }}</h6>
                    @include('home-parts.modal.envelope-actions')
                </div>
            </div>
        </div>
    @endforeach
    @include('home-parts.modal.add-envelope')
</div>


&nbsp;


