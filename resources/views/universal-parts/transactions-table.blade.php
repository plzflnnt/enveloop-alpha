<table class="table table-striped">
    <thead class="">
    <tr>
        <th>Valor</th>
        <th>Descrição</th>
        <th class="d-none d-sm-block" {{$feed[0]->envelope == null ? "style=display:none!important":""}}>Categoria</th>
        <th>Data</th>
    </tr>
    </thead>
    <tbody>
    @foreach($feed as $item)
        <?
        $style = "";
        $styleTwo = "";
        $color = "";
        if($item->type == 1 ){
            $style = "fa-arrow-up";
            $color = "#28a745";
        }elseif($item->type == 2 ){
            $style = "fa-circle fa-xs";
            $color = "#3659D6";
            $styleTwo = ";font-style: italic;color:#777777";
        }elseif($item->type == 4){
            $style = "fa-arrow-down";
            $color = "#f2756a";
        }elseif($item->type == 3 ){
            $style = "fa-arrow-down";
            $color = "#f2756a";
        }
        date_default_timezone_set('America/Sao_Paulo');
        ?>
        <tr>
            <td><i class="fa {{ $style }}" style="color: {{ $color }}"></i>
                &nbsp;R$ {{ \App\Envelope::formatCurrency($item->value) }}</td>
            <td style="width: 33%{{$styleTwo}}">{{ $item->name }}</td>
            <td {{$item->envelope == null ? "style=display:none!important":""}} class="d-none d-sm-block">{{ $item->envelope }}</td>
            <td>{{ date('d/m/y', strtotime($item->valid_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>