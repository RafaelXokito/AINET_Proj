
<!-- Modal -->
<div class="modal fade" id="createOrEditModal" tabindex="-1" role="dialog" aria-labelledby="createOrEditModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fad fa-boxes"></i> <span id="modalTitle">Criar Categoria</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('categorias.store')}}" id="formStore" method="POST">@csrf</form>
                <form action="{{route('categorias')}}" id="formUpdate" method="POST">@csrf @method('PUT')</form>
                <div class="row">
                    <div class="form-group col">
                        <label for="inputNomeModal">Nome</label>
                        <input type="text" class="form-control" placeholder="Nome" form="formStoreUpdate" name="nome" id="inputNomeModal" >
                        @error('nome')
                            <div class="small text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="formStoreUpdate" id="modalCriarBtn">Criar</button>
            </div>
        </div>
    </div>
</div>
