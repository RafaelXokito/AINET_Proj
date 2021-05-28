@extends('layout')
@section('title','Estampas' )
@section('content')
@if (count($estampas) == 0)
<div class="text-center pt-5">
    <h3>Você ainda não tem estampas. Crie algumas primeiro!</h3>
</div>
@endif
<div class="card-columns">
    @foreach ($estampas as $estampa)
    <div class="card">
        @isset($estampa->cliente_id)
        <img src="{{route('estampas.show',['estampa' => $estampa])}}" class="card-img-top" alt="...">
        @else
        <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" class="card-img-top" alt="...">
        @endisset

        <div class="card-body">
            <h5 class="card-title">{{$estampa->nome}}</h5>
            <p class="card-text">{{$estampa->descricao}}</p>
            <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">
    {!! $estampas->links("pagination::bootstrap-4") !!}
</div>
@endsection
