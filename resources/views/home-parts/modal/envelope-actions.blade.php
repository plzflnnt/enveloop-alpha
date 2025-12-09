<!-- Button trigger modal -->
<a data-toggle="modal" data-target="#envelopeModalEarning-{{$envelope->id}}" class="card-link btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-up"></i>&nbsp;Investir</a>
<a data-toggle="modal" data-target="#envelopeModalExpense-{{$envelope->id}}" class="card-link btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-down"></i>&nbsp;Despesa</a>

<!-- Modal Earning -->
<div class="modal fade" id="envelopeModalEarning-{{$envelope->id}}" tabindex="-1" role="dialog" aria-labelledby="envelopeModalEarning-{{$envelope->id}}"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle">Aplicar em {{$envelope->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-earning-spense needs-validation" method="post" action="{{ url('new-earning') }}" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="earning-group">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-center">Aplicar dinheiro do saldo ao envelope.</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" value="Aplicação ao envelope"
                                           class="form-control-sm form-control" name="name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group input-money">
                                    <input type="text" placeholder="Valor" class="form-control-sm form-control"
                                           name="value" required>
                                    <div class="invalid-feedback">
                                        Informe o valor
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control-sm form-control" name="valid_at">
                                </div>
                            </div>
                            
                            <input type="hidden" name="envelope_id" value="{{$envelope->id}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">Aplicar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Expense -->
<div class="modal fade" id="envelopeModalExpense-{{$envelope->id}}" tabindex="-1" role="dialog" aria-labelledby="envelopeModalExpense-{{$envelope->id}}"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Despesa em {{$envelope->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-earning-spense needs-validation" method="post" action="{{ url('new-expense') }}" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="earning-group">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-center">Adicionar um gasto ao envelope.</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Descrição Ex.'Compras'"
                                           class="form-control-sm form-control" name="name" required>
                                    <div class="invalid-feedback">
                                        Informe a descrição
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group input-money">
                                    <input type="text" placeholder="Valor" class="form-control-sm form-control"
                                           name="value" required>
                                    <div class="invalid-feedback">
                                        Informe o valor
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control-sm form-control" 
                                           name="valid_at">
                                </div>
                            </div>
                            <input type="hidden" name="envelope_id" value="{{$envelope->id}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>