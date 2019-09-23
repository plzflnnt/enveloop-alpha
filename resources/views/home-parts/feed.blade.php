&nbsp;
<div class="row">
    <div class="col">
        @if(count($feed) != 0)
            @include('home-parts.transactions-table')
            <p class="text-center mt-3"><a href="{{ url('transactions') }}" class="btn btn-outline-primary">Ver mais</a></p>
        @endif
    </div>
</div>


