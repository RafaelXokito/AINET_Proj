@extends('layout')
@section('title','Carrinho de compras' )
@section('content')
<br>
<hr>
<br>
<form action="{{ route('carrinho.destroy') }}" method="POST">
    @csrf
    @method("DELETE")
    <div class="row mb-5 ml-5">
        <div class="col">
            <input type="submit" class="btn btn-danger" value="Apagar carrinho">
        </div>
    </div>
</form>
<input type="number" id="quantidadeDesconto" value="{{$precos->quantidade_desconto}}" hidden>
<input type="number" id="valorPropDesconto" value="{{$precos->preco_un_proprio_desconto}}" hidden>
<input type="number" id="valorPubDesconto" value="{{$precos->preco_un_catalogo_desconto}}" hidden>
<input type="number" id="valorPropSemDesconto" value="{{$precos->preco_un_proprio}}" hidden>
<input type="number" id="valorPubSemDesconto" value="{{$precos->preco_un_catalogo}}" hidden>
<div class="px-4 px-lg-0">
    <div class="pb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

            <!-- Shopping cart table -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="border-0 bg-light">
                        <div class="p-2 px-3 text-uppercase"></div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                        <div class="py-2 px-3 text-uppercase">Produto</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Quantidade</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Tamanho</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Cor</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Pre??o</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                        <div class="py-2 text-uppercase">Sub-Total</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase"></div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($carrinho as $row)
                        <tr>

                            <th scope="row" class="border-0">
                                <div class="p-2">
                                <img id="previewImage{{$i}}" width="70" class="img-fluid rounded shadow-sm" src="{{route('estampas.preview', ['estampa' => $row['estampa'], 'cor' => $row['cor_codigo'], 'posicao' => $informacoesextra[$row['key']]['inputPosicao'] ?? 'top', 'rotacao' => $informacoesextra[$row['key']]['inputRotacao'] ?? '0', 'opacidade' => $informacoesextra[$row['key']]['inputOpacidade'] ?? '100', 'zoom' => $informacoesextra[$row['key']]['inputZoom'] ?? '0']) }}">
                                </div>
                            </th>
                            <th scope="row" class="border-0 align-middle">
                            <div class="p-2">
                                <div class="ml-3 d-inline-block align-middle" id="title{{$i}}" data-client="{{$row['estampa']->cliente_id}}">
                                    @if ($row['estampa']->cliente_id == null)
                                        <h5 class="mb-0"> <a href="{{route('estampas.view', ['estampa' => $row['estampa']])}}" id="{{$row['key']}}" class="text-dark d-inline-block align-middle">{{$row['estampa']->nome}}</a></h5>
                                    @else
                                        <h5 class="mb-0"> <a href="{{route('estampas.edit', ['estampa' => $row['estampa']])}}" id="{{$row['key']}}" class="text-dark d-inline-block align-middle">{{$row['estampa']->nome}}</a></h5>
                                    @endif
                                </div>
                            </div>
                            </th>
                            <td class="border-0 align-middle"><div class="p-2" onclick="alterarCarrinhoLoadRow({{$i}})"><a id="quantidade{{$i}}" href="" data-qtd="{{ $row['quantidade'] }}" class="text-dark d-inline-block align-middle" data-toggle="modal" data-target=".bd-example-modal-lg"><strong>{{ $row['quantidade'] }}</strong> <i class="fas fa-caret-down"></i></a></div></td>
                            <td class="border-0 align-middle"><div class="p-2" onclick="alterarCarrinhoLoadRow({{$i}})"><a id="tamanho{{$i}}" href="" data-size="{{ $row['tamanho'] }}" class="text-dark d-inline-block align-middle" data-toggle="modal" data-target=".bd-example-modal-lg"><strong>{{ $row['tamanho'] }}</strong> <i class="fas fa-caret-down"></i></a></div></td>
                            <td class="border-0 align-middle"><div class="p-2" onclick="alterarCarrinhoLoadRow({{$i}})"><a id="cor{{$i}}" href="" data-color="{{ $row['cor_codigo'] }}" class="text-dark d-inline-block align-middle" data-toggle="modal" data-target=".bd-example-modal-lg"><strong><img id="colorInputCor{{$i}}" style="width: 16px; height: 16px; background-color: #{{ $row['cor_codigo'] }}" /></strong> <i class="fas fa-caret-down"></i></a></div></td>
                            <td class="border-0 align-middle"><div class="p-2" id="precoUn{{$i}}"><strong>{{ number_format($row['preco_un'],2) }}???</strong></div></td>
                            <td class="border-0 align-middle"><div class="p-2"><strong><span class="subtotal" >{{ number_format($row['subtotal'], 2) }}</span>???</strong></div></td>
                            <td class="border-0 align-middle">
                                <form action="{{route('carrinho.update_tshirt', ['key' => $row['key']])}}" method="POST" id="formUpdateCarrinho{{$i}}">
                                    @csrf
                                    @method('put')
                                </form>
                                <form action="{{route('carrinho.destroy_tshirt', $row['key'])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn text-dark"><i class="fa fa-trash"></i></button>
                                </form>
                                <button type="button" onclick="alterarCarrinhoLoadRow({{$i}})" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn text-dark"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        @php
                            $i += 1;
                        @endphp
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- End -->
          </div>
        </div>
        <form action="{{ route('carrinho.store') }}" method="POST">
        @csrf
        <div class="row py-5 p-4 bg-white rounded shadow-sm">
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Informa????o da encomenda</div>
            <div class="p-4">
                <div class="input-group mb-4 border rounded-pill p-2">
                    <input type="text" placeholder="NIF" name="nif" value="{{old('nif', $user->cliente->nif ?? '')}}" aria-describedby="button-addon3" class="form-control border-0">
                </div>
                @error('nif')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
                <div class="input-group mb-4 border rounded-pill p-2">
                    <input type="text" placeholder="Morada" name="endereco" value="{{old('endereco', $user->cliente->endereco ?? '')}}" aria-describedby="button-addon3" class="form-control border-0">
                    @error('endereco')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="input-group mb-4 border rounded-pill p-2">
                    <select name="tipo_pagamento" id="tipo_pagamento" class="form-control border-0 selectpicker">
                        <option value="vazio" selected>M??todo Pagamento</option>
                        <option value="VISA" {{"VISA" == old('tipo_pagamento', $user->cliente->tipo_pagamento ?? '') ? 'selected' : ''}} aria-describedby="button-addon3"  class="form-control border-0">VISA</option>
                        <option value="MC" {{"MC" == old('tipo_pagamento', $user->cliente->tipo_pagamento ?? '') ? 'selected' : ''}} aria-describedby="button-addon3" class="form-control border-0">MC</option>
                        <option value="PAYPAL" {{"PAYPAL" == old('tipo_pagamento', $user->cliente->tipo_pagamento ?? '') ? 'selected' : ''}} aria-describedby="button-addon3" class="form-control border-0">PAYPAL</option>
                    </select>

                    @error('tipo_pagamento')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="input-group mb-4 border rounded-pill p-2" id="ref_pagamento_div">
                    <input id="ref_pagamento" name="ref_pagamento" value="{{old('ref_pagamento', $user->cliente->ref_pagamento ?? '')}}" type="text" placeholder="Referencia do pagamento" aria-describedby="button-addon3" class="form-control border-0">
                </div>
                @error('ref_pagamento')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
            </div>

          </div>
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instru????es para o vendedor</div>
            <div class="p-4">
                <p class="font-italic mb-4">Se tem alguma informa????o para o vendedor voc?? pode escrever aqui em baixo.</p>
                <textarea name="notas" cols="30" rows="2" class="form-control"></textarea>
                @error('notas')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Sum??rio da encomenda</div>
            <div class="p-4">
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                  <h5 class="font-weight-bold"><span id="totalOrder"></span>???</h5>
                </li>
              </ul><button href="" type="submit" class="btn btn-dark rounded-pill py-2 btn-block">Continuar com a compra</button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    </div>

    @include('carrinho.partials.modal')

<script src="{{asset('js/carrinho.js')}}"></script>

@endsection
