&nbsp;
<div class="feed-group">
    <div class="row">
        <div class="col">
            @if(count($feed) != 0)
                @include('universal-parts.transactions-table')
                <p class="text-center"><a href="{{ url('transactions') }}" class="btn btn-outline-primary">Ver mais lançamentos</a></p>
            @endif
        </div>
    </div>
</div>