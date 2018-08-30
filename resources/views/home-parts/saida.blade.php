<div class="earning-group">
    &nbsp;
    <form class="form-earning-spense" method="post" action="{{ url('new-expense') }}">
        @csrf
        <div class="row">
            <div class="col-xs-12">
                <p class="text-center">Adicionar despesa: adicione uma despesa e de qual fonte você ira retirar o valor.</p>
            </div>
        </div>
        <div class="form-row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <input type="text" placeholder="Descrição" class="form-control-sm form-control" name="name">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group input-money">
                    <input type="text" placeholder="Valor" class="form-control-sm form-control" name="value">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <select class="form-control-sm form-control" name="envelope_id">
                        <option value="sd">Saldo</option>
                        @foreach($envelopes as $envelope)
                            <option value="{{ $envelope->id }}">{{ $envelope->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-outline-primary btn-sm btn-block">Adicionar</button>
            </div>
        </div>
    </form>
</div>