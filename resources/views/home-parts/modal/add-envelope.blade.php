<!-- Button trigger modal -->
<div class="col-12 col-md-6 col-lg-4">
    <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#exampleModalCenter">
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

            <form method="post" class="needs-validation" action="{{ url('new-envelope') }}" novalidate>
                @csrf
                <div class="modal-body">
                    <p>Adicione um envelope para categoria de gastos em sua vida, seja ele do dia a dia ou
                        para
                        um investimento maior.</p>
                    <div class="form-group">
                        <label for="envelope">Nome do envelope</label>
                        <input type="text" class="form-control" name="name" required>
                        <div class="invalid-feedback">
                            Informe um nome ao envelope
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