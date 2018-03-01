<div class="earning-group">
    &nbsp;
    <form class="form-earning-spense" method="post" action="{{ url('new-expense') }}">
        @csrf
        <div class="form-row">
            <div class="col-12 col-md-5">
                <div class="form-group">
                    <input type="text" placeholder="Valor" class="form-control-sm" name="value">
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="form-group">
                    <select class="form-control-sm" name="envelope_id">
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
</div>