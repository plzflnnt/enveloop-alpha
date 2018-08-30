<!-- Button trigger modal -->
<h5>Saldo: <span style="color: <?= ($balance <= 0) ? '#f2756a' : '#89e17a' ?>">R$ {{ $balance }}</span>&nbsp; <br class="d-block d-sm-none">
    <a data-toggle="modal" data-target="#balanceModalEarning" style="font-size: 1rem" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-up"></i>&nbsp;Ganho
    </a>
    <a data-toggle="modal" data-target="#balanceModalExpense" style="font-size: 1rem" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-down"></i>&nbsp;Despesa
    </a>
</h5>

<!-- Modal Earning -->
<div class="modal fade" id="balanceModalEarning" tabindex="-1" role="dialog" aria-labelledby="balanceModalEarning"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um novo ganho</h5>
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
                                <p class="text-center">Adicione uma ganho em seu saldo sempre que você receber algum
                                    dinheiro.</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Descrição Ex.'Salário'"
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
                            <input type="hidden" name="envelope_id" value="sd">
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

<!-- Modal Expense -->
<div class="modal fade" id="balanceModalExpense" tabindex="-1" role="dialog" aria-labelledby="balanceModalExpense"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar despesa ao saldo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-earning-spense needs-validation" method="post" action="{{ url('new-expense') }}" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="earning-group">
                        &nbsp;
                        <div class="row">
                            <div class="col-12">
                                <p class="text-center">Essa despesa não será
                                    vinculada a um envelope, para adicionar uma despesa referente a uma categoria de
                                    envelope, clique em despesa dentro do envelope desejado.</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Descrição Ex.'Gasto impevisto'"
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
                            <input type="hidden" name="envelope_id" value="sd">
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