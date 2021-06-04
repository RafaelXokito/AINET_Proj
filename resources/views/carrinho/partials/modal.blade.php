
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
                            <img id="previewImageModal" width="" class="img-fluid rounded shadow-sm" src="{{route('estampas.preview', ['estampa' => $row['estampa'], 'cor' => $row['cor_codigo'], 'posicao' => $informacoesextra[$row['id']]['inputPosicao'] ?? 'top', 'rotacao' => $informacoesextra[$row['id']]['inputRotacao'] ?? '0', 'opacidade' => $informacoesextra[$row['id']]['inputOpacidade'] ?? '100', 'zoom' => $informacoesextra[$row['id']]['inputZoom'] ?? '0']) }}">
                        </div>
                        <div class="col d-flex align-items-center">
                        <form method="POST" action="" id="formAlterarCarrinho">
                            @csrf
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
                                            <input type="number" class="form-control" id="inputPrecoUni" value="">
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
