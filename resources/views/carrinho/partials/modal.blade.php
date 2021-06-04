

    <div class="modal fade bd-example-modal-lg" id="alterarCarrinhoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-shopping-cart"></i> Alterar carrinho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <input value="{{route('estampas')}}" id="formPreview" hidden>
                            <img id="previewImageModal" width="" class="img-fluid rounded shadow-sm" src="">
                        </div>
                        <div class="col d-flex align-items-center">
                        <form method="POST" action="" id="formAlterarCarrinho">
                            @csrf
                            @method('PUT')
                            <div class="row d-flex justify-content-center mt-5 text-center">
                                <div class="form-group col-6">
                                    <label for="inputCorModal">Cor da t-shirt</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text  border-0" id="">
                                                <img id="colorinputCorModal" style="width: 16px; height: 16px; background-color: #" />
                                            </span>
                                        </div>
                                        <select class="form-control" name="cor_codigo" id="inputCorModal">
                                            <!--<option value="" selected>Escolher cor...</option>-->
                                            @foreach ($cores as $abr => $nome)
                                            <option value={{$abr}} >{{$nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('cor_codigo')
                                        <div class="small text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="inputTamanho">Tamanho</label>
                                    <select class="form-control" name="tamanho" id="inputTamanho">
                                        <option value="XS">XS</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                    @error('tamanho')
                                        <div class="small text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label for="inputQuantidade">Quantidade</label>
                                    <input type="number" class="form-control quantity" placeholder="0" min="0" name="quantidade" id="inputQuantidade" >
                                    @error('quantidade')
                                        <div class="small text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <fieldset disabled>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text">Preço Uni.</div>
                                            </div>
                                            <input type="number" class="form-control" id="inputPrecoUni" value="0.00">
                                            <div class="input-group-append">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text">Sub-Total</div>
                                            </div>
                                            <input type="number" class="form-control" id="inputSubTotal" value="0.00">
                                            <div class="input-group-append">
                                                <div class="input-group-text">€</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                        </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="formAlterarCarrinho" class="btn btn-primary">Guardar Alterações</button>
                </div>
            </div>
        </div>
        </div>
