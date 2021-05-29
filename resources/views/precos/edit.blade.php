@extends('layout')
@section('title','Definição de preços' )
@section('content')

<form action="{{ route('precos.update', ['precos' => $precos]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-row row">
        <div class="form-col col">
            <label for="preco_un_catalogo">T-shirt com estampa do catálogo da loja</label>
            <i class="fas fa-book-open"></i>
            <div class="input-group mb-3 col-4">
                <input id="preco_un_catalogo" name="preco_un_catalogo" value="{{$precos->preco_un_catalogo}}" type="number" class="form-control text-right" placeholder="0.00" aria-label="Amount (to the nearest euro)">
                <div class="input-group-append">
                <span class="input-group-text">€</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row row">
        <div class="form-col col">
            <label for="preco_un_proprio">T-shirt com estampa definida pelo cliente</label>
            <i class="fas fa-users"></i>
            <div class="input-group mb-3  col-4">
                <input id="preco_un_proprio" name="preco_un_proprio" value="{{$precos->preco_un_proprio}}" type="number" class="form-control text-right" placeholder="0.00" aria-label="Amount (to the nearest euro)">
                <div class="input-group-append">
                <span class="input-group-text">€</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row row">
        <div class="form-col col">
            <label for="preco_un_catalogo_desconto">T-shirt com estampa do catálogo da loja e com desconto de quantidade</label>
            <i class="fas fa-book-open"></i>
            <i class="fas fa-tags"></i>
            <div class="input-group mb-3 col-4">
                <input id="preco_un_catalogo_desconto" name="preco_un_catalogo_desconto" value="{{$precos->preco_un_catalogo_desconto}}" type="number" class="form-control text-right" placeholder="0.00" aria-label="Amount (to the nearest euro)">
                <div class="input-group-append">
                <span class="input-group-text">€</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row row">
        <div class="form-col col">
            <label for="preco_un_proprio_desconto">T-shirt com estampa definida pelo cliente e com desconto de quantidade</label>
            <i class="fas fa-users"></i>
            <i class="fas fa-tags"></i>
            <div class="input-group mb-3  col-4">
                <input id="preco_un_proprio_desconto" name="preco_un_proprio_desconto" value="{{$precos->preco_un_proprio_desconto}}" type="number" class="form-control text-right" placeholder="0.00" aria-label="Amount (to the nearest euro)">
                <div class="input-group-append">
                <span class="input-group-text">€</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row row">
        <div class="form-col col">
            <label for="quantidade_desconto">Quantidade a partir da qual a loja aplica os preços com desconto</label>
            <i class="fas fa-sort-amount-up"></i>
            <div class="input-group mb-3  col-4">
                <input id="quantidade_desconto" name="quantidade_desconto" value="{{$precos->quantidade_desconto}}" type="number" class="form-control" placeholder="0" aria-label="Quantity">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row m-3">
            <div class="form-col text-center col-lg-12">
                <button class="btn btn-primary" type="submit">Submeter</button>
            </div>
        </div>
    </div>
</form>

@endsection
