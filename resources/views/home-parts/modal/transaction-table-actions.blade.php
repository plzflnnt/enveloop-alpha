<a title="Apagar item, não pode ser desfeito!" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteItemModal-{{$item->id}}"><i class="btn-outline-danger fa fa-trash"></i></a>

{{--<a class="btn btn-outline-dark btn-sm" title="Editar item" data-toggle="modal" data-target="#editItemModal-{{$item->id}}"><i class="fa fa-edit btn-outline-dark"></i></a>--}}
@if($item->envelope_id!=1)
    <a href="{{ url("envelope/".encrypt($item->envelope_id)) }}"title="Ir para a página do envelope" class="btn btn-outline-primary btn-sm"><i class="fa fa-share"></i></a>
@endif

<!-- Modal Delete -->
<div class="modal fade" id="deleteItemModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteItemModal-{{$item->id}}"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Apagar item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja apagar definitivamente o item:</p>
                <table style="width: 100%">
                    <tr>
                        <td><i class="fa {{ $style }}" style="color: {{ $color }}"></i>
                            &nbsp;R$ {{ \App\Envelope::formatCurrency($item->value) }}</td>
                        <td style="width: 33%{{$styleTwo}}">{{ $item->name }}</td>
                        <td {{$item->envelope == null ? "style=display:none!important":""}} class="d-none d-sm-block">{{ $item->envelope }}</td>
                    </tr>
                </table>
                <p style="margin-top: 10px">Esta ação não poderá ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                <a href="{{url("undo-earning/".encrypt($item->id))}}" class="btn btn-outline-danger">Apagar</a>
            </div>
        </div>
    </div>
</div>



<!-- Modal Edit -->
<div class="modal fade" id="editItemModal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editItemModal-{{$item->id}}"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Função em desenvolvimento</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>

            </div>
        </div>
    </div>
</div>
