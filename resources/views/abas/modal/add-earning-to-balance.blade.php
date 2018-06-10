<!-- Button trigger modal -->
<a data-toggle="modal" data-target="#ballanceModal">
    Saldo não alocado: <span style="color: <?= ($balance <= 0) ? '#f2756a' : '#89e17a' ?>" data-toggle="tooltip" data-placement="bottom" title="Clique no + para adicionar um ganho">R$ {{ $balance }}
        <i class="fa fa-plus-circle" style="font-weight: lighter;font-size: 10pt; color: #1b1e21"></i></span>
</a>


<!-- Modal -->
<div class="modal fade" id="ballanceModal" tabindex="-1" role="dialog" aria-labelledby="ballanceModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um novo ganho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form-earning-spense" method="post" action="{{ url('new-earning') }}">
                @csrf
                <div class="modal-body">

                    {{--new--}}
                    <div class="earning-group">
                        &nbsp;
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="text-center">Adicione uma ganho em seu saldo sempre que você receber algum
                                    dinheiro.</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Descrição Ex.'Salário'"
                                           class="form-control-sm form-control" name="name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group input-earning-spense">
                                    <input type="text" placeholder="Valor" class="form-control-sm form-control"
                                           name="value">
                                </div>
                            </div>
                            <input type="hidden" name="envelope_id" value="sd">
                            {{--<div class="form-row">--}}
                            {{--<div class="col-md-4 col-12">--}}
                            {{--<div class="form-group">--}}
                            {{--<select class="form-control-sm form-control" name="envelope_id">--}}
                            {{--<option value="10">Adiar 10 dias</option>--}}
                            {{--<option value="15">{{ $envelope->name }}</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4 col-12">--}}

                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    {{--new--}}


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>