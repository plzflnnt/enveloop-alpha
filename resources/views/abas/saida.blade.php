<div class="earning-group">
    &nbsp;
    <div class="row">
        <form action="{{ url('new-expense') }}">
            <div class="col">
                <div class="form-group">
                    <label for="envelope">Valor</label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="form-control" name="envelope_id">
                        @foreach($envelopes as $envelope)
                            <option value="{{ $envelope->id }}">{{ $envelope->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>