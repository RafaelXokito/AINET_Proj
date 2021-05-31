
<!-- Modal -->
<div class="modal fade" id="createOrEditModal" tabindex="-1" role="dialog" aria-labelledby="createOrEditModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-palette"></i> <span id="modalTitle">Criar Cor</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('cores')}}" id="formStoreUpdate" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="inputCodigoModal">Código</label>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">#</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Código" form="formStoreUpdate" name="codigo" id="inputCodigoModal" >
                        </div>
                        @error('codigo')
                            <div class="small text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <div class="form-group col">
                            <label for="inputNomeModal">Nome</label>
                            <input type="text" class="form-control" placeholder="Nome" form="formStoreUpdate" name="nome" id="inputNomeModal" >
                            @error('nome')
                                <div class="small text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <!--TODO aparecer ou desaparecer esta div se há ou não imagem selecionada-->
                <div class="row mb-5 d-none" id="imageSelected">
                    <div class="col text-center">
                        <img class="img-fluid" style="max-height: 300px" id="inputUploadedFotoModal" src="{{'storage\tshirt_base\\'}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="inputFotoModal">T-Shirt</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" form="formStoreUpdate" name="foto" id="inputFotoModal">
                            <label class="custom-file-label" for="inputFotoModal" id="inputFotoModalLabel">Choose file</label>
                        </div>
                        @error('foto')
                            <div class="small text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="formStoreUpdate" id="modalCriarBtn">Criar</button>
            </div>
        </div>
    </div>
</div>
