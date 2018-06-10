&nbsp;
<div class="feed-group">
    <div class="row">
        <div class="col">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                @foreach($feed as $item)
                    <?
                    $style = "";
                    if($item->type == 1 ){
                        $style = "fa-arrow-up";
                    }elseif($item->type == 2 ){
                        $style = "fa-arrow-up";
                    }elseif($item->type == 4){
                        $style = "fa-arrow-down";
                    }elseif($item->type == 3 ){
                        $style = "fa-arrow-down";
                    }
                    $color = "";
                    if($item->type == 1 ) {
                        $color = "#89e17a";
                    }elseif($item->type ==  2){
                        $color = "#89e17a";
                    }elseif($item->type ==  3){
                        $color = "#f2756a";
                    }elseif($item->type ==  4){
                        $color = "#f2756a";
                    }
                    date_default_timezone_set('America/Sao_Paulo');
                    ?>
                    <tr>
                        <td><i class="fa {{ $style }}" style="color: {{ $color }}"></i>
                            &nbsp;R$ {{ \App\Envelope::formatCurrency($item->value) }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->envelope }}</td>
                        <td>{{ date('d/m/y H:i', strtotime($item->updated_at)) }}</td>
                    </tr>
                @endforeach
                @if(count($feed) == 0)
                    <tr>
                        <td colspan="3" class="text-center">Tudo tão silêncioso por aqui 🌚</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $feed->links() }}
        </div>
    </div>
</div>