&nbsp;
<div class="feed-group">
    <div class="row">
        <div class="col">
            @if(count($feed) != 0)
            @include('universal-parts.transactions-table')
                {{ $feed->links() }}
            @else
                <p class="text-center text-muted">Ainda não há lançamentos neste envelope, começe clicando em investir.</p>
            @endif
        </div>
    </div>
</div>