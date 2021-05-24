@extends('layout')
@section('title','Estampas' )
@section('content')
<div class="card-columns">
    @foreach ($estampas as $estampa)
    <div class="card">
        <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{$estampa->nome}}</h5>
            <p class="card-text">{{$estampa->descricao}}</p>
            <a href="#" class="btn btn-primary">Ver Estampa na t-shirt</a>
        </div>
    </div>

    @endforeach
</div>
<!--<div class="estampa-area">
    <div class="card-deck">
        88@foreach($estampas as $estampa)
        <div class="col-sm-3 d-flex">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{$estampa->imagem_url ?
                    asset('storage/estampas/' . $estampa->imagem_url) :
                    asset('img/default_img.png') }}" alt="Imagem da Estampa">
                <div class="card-body">
                <h5 class="card-title">{{$estampa->nome}}</h5>
                <p class="card-text">{{$estampa->descricao}}</p>
                </div>
            </div>
        </div>
        88@endforeach
    </div>
</div>-->
<div class="d-flex justify-content-center">
    {!! $estampas->links() !!}
</div>

@endsection
