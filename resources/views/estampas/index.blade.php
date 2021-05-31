@extends('layout')
@section('title','Estampas' )
@section('content')

<div class="row mb-3">
    <div class="col-9">
        <form method="GET" action="{{Route::currentRouteName()=='estampas' ? route('estampas') : route('estampasUser', ['user' => Auth::user()]) }}" class="form-group">
            <div class="input-group">
                <select class="form-control" name="categoria" id="inputCategoria">
                    <option value="" selected>Todas as categoria...</option>
                    <option value="0" {{$categoria == '0' ? 'selected' : ''}}>Sem categoria</option>
                    @foreach ($categorias as $abr => $nomeCategoria)
                    <option value={{$abr}} {{$abr == $categoria ? 'selected' : ''}}>{{$nomeCategoria}}</option>
                    @endforeach
                </select>
                <input id="inputNome" name="nome" class="form-control" placeholder="Nome" value="{{$nome}}">
                <input id="inputDescricao" name="descricao" class="form-control" placeholder="Descrição" value="{{$descricao}}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@if (count($estampas) == 0)
<div class="text-center pt-5">
    @if (Route::currentRouteName()=='estampas')
        <h3>Não foram encontradas estampas!</h3>
    @else
        <h3>Você ainda não tem estampas. Crie algumas primeiro!</h3>
    @endif
</div>
@else
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
            <div class="row">
                <div class="col">
                    @if ($estampa->cliente_id == null)
                        <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @else
                        <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @endif
                </div>
                <div class="col-1">
                    <a href=""></a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">
    {!! $estampas->withQueryString()->links("pagination::bootstrap-4") !!}
</div>
@endif
@endsection
