<div class="earning-group">
    &nbsp;
    <form class="form-earning-spense" method="post" action="{{ url('new-earning') }}">
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
                        <th>Categoria</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($earnings as $earning)
                        <tr>
                            <td>{{ $earning->envelope }}</td>
                            <td><i class="fa fa-arrow-up" style="color: #28a745"></i> &nbsp;{{ \App\Envelope::formatCurrency($earning->value) }}</td>
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
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>
                @foreach($balanceEarnings as $earning)
                    <tr>
                        <td>{{ $earning->updated_at }}</td>
                        <td><i class="fa fa-arrow-up" style="color: #28a745"></i> &nbsp;{{ \App\Envelope::formatCurrency($earning->value) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    (function($, undefined) {

        "use strict";

        // When ready.
        $(function() {

            var $form = $( ".form-earning-spense" );
            var $input = $form.find( "input" );

            $input.on( "keyup", function( event ) {


                // When user select text in the document, also abort.
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {
                    return;
                }

                // When the arrow keys are pressed, abort.
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                    return;
                }


                var $this = $( this );

                // Get the value.
                var input = $this.val();

                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $this.val( function() {
                    var valuefinal = ( input === 0 ) ? "" : input/100;
                    return valuefinal.toLocaleString("pt-BR", {style:"currency", currency:"BRL"})
                } );
            } );
        });
    })(jQuery);
</script>