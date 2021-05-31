@extends('layout')
@section('title','Estampas' )
@section('content')

<div class="row mb-3">
    <div class="col">
        <form method="GET" action="{{Route::currentRouteName()=='estampas' ? route('estampas') : route('estampasUser', ['user' => Auth::user()]) }}" class="form-group">
            <div class="input-group">
                @can('isAdmin', App\Models\User::class)
                    <select class="form-control col-3" name="apagado">
                        <option value="notDeleted" {{'notDeleted' == $apagado ? 'selected' : 'notDeleted'}} class="dropdown-item">Estampas Disponíveis</option>
                        <option value="all" {{'all' == $apagado ? 'selected' : 'all'}} class="dropdown-item">Todas as Estampas</option>
                        <option value="deleted" {{'deleted' == $apagado ? 'selected' : 'deleted'}} class="dropdown-item">Estampas Apagadas</option>
                    </select>
                @endcan
                <select class="form-control col-3" name="categoria" id="inputCategoria">
                    <option value="" selected>Todas as categorias...</option>
                    <option value="0" {{$categoria == '0' ? 'selected' : ''}}>Sem categoria</option>
                    @foreach ($categorias as $abr => $nomeCategoria)
                    <option value={{$abr}} {{$abr == $categoria ? 'selected' : ''}}>{{$nomeCategoria}}</option>
                    @endforeach
                </select>
                <input id="inputNome" name="nome" class="form-control col-2" placeholder="Nome" value="{{$nome}}">
                <input id="inputDescricao" name="descricao" class="form-control col-3" placeholder="Descrição" value="{{$descricao}}">
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
                        @can('edit', $estampa)
                            <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver/Editar Estampa</a>
                        @endcan
                        @cannot('edit', $estampa)
                            <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                        @endcan
                    @else
                        <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @endif
                </div>
                @if (!$estampa->trashed())
                    @can('delete', App\Models\Estampa::class)
                        <form action="{{route('estampas.delete', ['estampa' => $estampa])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <div class="col-2 pl-0">
                                <button type="submit" class="btn btn-outline-danger"><i class="fad fa-trash"></i></button>
                            </div>
                        </form>
                    @endcan
                @else
                    @can('restore', App\Models\Estampa::class)
                        <form action="{{route('estampas.restore', ['id' => $estampa->id])}}" method="POST">
                            @csrf
                            <div class="col-2 pl-0">
                                <button class="btn btn-outline-success"><i class="fad fa-trash-restore"></i></button>
                            </div>
                        </form>
                    @endcan
                @endif

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
