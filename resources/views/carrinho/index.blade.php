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
                      <div class="py-2 text-uppercase">Preço</div>
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
                                <img id="previewImage{{$i}}" width="70" class="img-fluid rounded shadow-sm" src="{{route('estampas.preview', ['estampa' => $row['estampa'], 'cor' => $row['cor_codigo'], 'posicao' => $informacoesextra[$row['id']]['inputPosicao'] ?? 'top', 'rotacao' => $informacoesextra[$row['id']]['inputRotacao'] ?? '0', 'opacidade' => $informacoesextra[$row['id']]['inputOpacidade'] ?? '100', 'zoom' => $informacoesextra[$row['id']]['inputZoom'] ?? '0']) }}">
                                </div>
                            </th>
                            <th scope="row" class="border-0 align-middle">
                            <div class="p-2">
                                <div class="ml-3 d-inline-block align-middle">
                                <h5 class="mb-0"> <a href="" id="{{$row['id']}}" data-toggle="modal" data-target=".bd-example-modal-lg" class="text-dark d-inline-block align-middle">{{$row['estampa']->nome}}</a></h5>
                                </div>
                            </div>
                            </th>
                            <td class="border-0 align-middle"><div class="p-2" onclick="alterarCarrinhoLoadRow({{$i}})"><a id="quantidade{{$i}}" href="" class="text-dark d-inline-block align-middle" data-toggle="modal" data-target=".bd-example-modal-lg"><strong>{{ $row['quantidade'] }}</strong> <i class="fas fa-caret-down"></i></a></div></td>
                            <td class="border-0 align-middle"><div class="p-2"><a id="tamanho{{$i}}" href="" class="text-dark d-inline-block align-middle" data-toggle="modal" data-target=".bd-example-modal-lg"><strong>{{ $row['tamanho'] }}</strong> <i class="fas fa-caret-down"></i></a></div></td>
                            <td class="border-0 align-middle"><div class="p-2"><a id="cor{{$i}}" href="" class="text-dark d-inline-block align-middle" data-toggle="modal" data-target=".bd-example-modal-lg"><strong><img id="colorInputCor" style="width: 16px; height: 16px; background-color: #{{ $row['cor_codigo'] }}" /></strong> <i class="fas fa-caret-down"></i></a></div></td>
                            <td class="border-0 align-middle"><div class="p-2"><strong>{{ number_format($row['preco_un'],2) }}€</strong></div></td>
                            <td class="border-0 align-middle"><div class="p-2"><strong><span class="subtotal" >{{ number_format($row['subtotal'], 2) }}</span>€</strong></div></td>
                            <td class="border-0 align-middle">
                                <form action="{{route('carrinho.destroy_tshirt', $row['id'])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn text-dark"><i class="fa fa-trash"></i></button>
                                </form>
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
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Informação da encomenda</div>
            <div class="p-4">
                <div class="input-group mb-4 border rounded-pill p-2">
                    <input type="text" placeholder="NIF" name="nif" aria-describedby="button-addon3" class="form-control border-0">
                    @error('nif')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="input-group mb-4 border rounded-pill p-2">
                    <input type="text" placeholder="Morada" name="endereco" aria-describedby="button-addon3" class="form-control border-0">
                    @error('endereco')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="input-group mb-4 border rounded-pill p-2">

                    <select name="tipo_pagamento" id="tipo_pagamento" class="form-control border-0 selectpicker">
                        <option value="vazio" selected>Método Pagamento</option>
                        <option value="VISA" aria-describedby="button-addon3"  class="form-control border-0">VISA</option>
                        <option value="MC" aria-describedby="button-addon3" class="form-control border-0">MC</option>
                        <option value="PAYPAL" aria-describedby="button-addon3" class="form-control border-0">PAYPAL</option>
                    </select>

                    @error('tipo_pagamento')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="input-group mb-4 border rounded-pill p-2" id="ref_pagamento_div">
                    <input id="ref_pagamento" name="ref_pagamento" type="text" placeholder="Referencia do pagamento" aria-describedby="button-addon3" class="form-control border-0">
                </div>
                @error('ref_pagamento')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
            </div>

          </div>
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instruções para o vendedor</div>
            <div class="p-4">
                <p class="font-italic mb-4">Se tem alguma informação para o vendedor você pode escrever aqui em baixo.</p>
                <textarea name="notas" cols="30" rows="2" class="form-control"></textarea>
                @error('notas')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Sumário da encomenda</div>
            <div class="p-4">
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                  <h5 class="font-weight-bold"><span id="totalOrder"></span>€</h5>
                </li>
              </ul><a href="" class="btn btn-dark rounded-pill py-2 btn-block">Continuar com a compra</a>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    </div>

    @include('carrinho.partials.modal')

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Id da Estampa</th>
            <th>Quantidade</th>
            <th>Tamanho</th>
            <th>Cor</th>
            <th>Preço uni.</th>
            <th>SubTotal</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($carrinho as $row)
    <tr>
        <td>{{ $row['estampa'] }} </td>
        <td>{{ $row['quantidade'] }} </td>
        <td>{{ $row['tamanho'] }} </td>
        <td>{{ $row['cor_codigo'] }} </td>
        <td>{{ $row['preco_un'] }} </td>
        <td>{{ $row['subtotal'] }} </td>
        <td>
            <form action="{{route('carrinho.update_tshirt', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="1">
                <input type="submit" value="Increment">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.update_tshirt', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="-1">
                <input type="submit" value="Decrement">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.destroy_tshirt', $row['id'])}}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Remove">
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<script src="{{asset('js/carrinho.js')}}"></script>

@endsection
