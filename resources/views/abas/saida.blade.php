<div class="earning-group">
    &nbsp;
    <form class="form-earning-spense" method="post" action="{{ url('new-expense') }}">
        @csrf
        <div class="form-row">
            <div class="col-12 col-md-5">
                <div class="form-group">
                    <input type="text" placeholder="Valor" class="form-control-sm form-control" name="value">
                </div>
            </div>
            <div class="col-12 col-md-5">
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
                <button type="submit" class="btn btn-outline-primary btn-sm">Adicionar</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col">
            <p>Envelopes</p>
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <td>Categoria</td>
                    <td>Valor</td>
                </tr>
                </thead>
                <tbody>
                @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->envelope }}</td>
                        <td>{{ \App\Envelope::formatCurrency($expense->value) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col">
            <p>Saldo</p>
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <td>Data</td>
                    <td>Valor</td>
                </tr>
                </thead>
                <tbody>
                @foreach($balanceExpenses as $expense)
                    <tr>
                        <td>{{ $expense->updated_at }}</td>
                        <td>{{ \App\Envelope::formatCurrency($expense->value) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>