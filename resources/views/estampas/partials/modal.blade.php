
<!-- Modal -->
<div class="modal fade" id="adicionarAoCarrinhoModal" tabindex="-1" role="dialog" aria-labelledby="adicionarAoCarrinhoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <input type="number" id="quantidadeDesconto" value="{{$precos->quantidade_desconto}}" hidden>
            <input type="number" id="valorDesconto" value="{{Route::currentRouteName()=='estampas.edit' ? $precos->preco_un_proprio_desconto : $precos->preco_un_catalogo_desconto}}" hidden>
            <input type="number" id="valorSemDesconto" value="{{Route::currentRouteName()=='estampas.edit' ? $precos->preco_un_proprio : $precos->preco_un_catalogo}}" hidden>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">Descontos disponíveis!</h4>
                    <p>Se adicionar {{$precos->quantidade_desconto}} ou mais T-shirts ao carrinho, será aplicado um desconto em cada uma das T-shirts.</p>
                    <hr>
                    <p class="mb-0">Para adicionar ao carrinho clique em "Confirmar".</p>
                </div>
                <form action="" id="formAdicionarAoCarrinho">
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
                                <input type="number" class="form-control" id="inputPrecoUni" value="{{Route::currentRouteName()=='estampas.edit' ? $precos->preco_un_proprio : $precos->preco_un_catalogo}}">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" form="formAdicionarAoCarrinho">Confirmar</button>
            </div>
        </div>
    </div>
</div>
