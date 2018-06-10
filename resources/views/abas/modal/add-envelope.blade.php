<!-- Button trigger modal -->
<div class="col-12 col-sm-4">
    <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal" data-target="#exampleModalCenter">
         Adicionar envelope <i class="fa fa-plus-circle" style="font-weight: lighter;font-size: 10pt;"></i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adicionar um novo envelope</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" action="{{ url('new-envelope') }}">
                @csrf
                <div class="modal-body">
                    <p>Adicione um envelope para categoria de gastos em sua vida, seja ele do dia a dia ou uma poupança
                        para
                        um investimento maior.</p>
                    <div class="form-group">
                        <label for="envelope">Nome do envelope</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="envelopeStyle">Cor</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="style" value="blue">
                            <label class="form-check-label" style="color:#007bff" for="inlineRadio1">Azul</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="style" value="green">
                            <label class="form-check-label" style="color:#28a745" for="inlineRadio2">Verde</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="style" value="yellow">
                            <label class="form-check-label" style="color:#ffc107" for="inlineRadio3">Amarelo</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="style" value="red">
                            <label class="form-check-label" style="color:#dc3545" for="inlineRadio2">Vermelho</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="style" value="dark">
                            <label class="form-check-label" style="color:#343a40" for="inlineRadio3">Preto</label>
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