@extends('layout')
@section('title','Estampas' )
@section('content')

<div class="row mb-3">
    <div class="col">
        <form method="GET" action="{{Route::currentRouteName()=='estampas' ? route('estampas') : route('estampasUser', ['user' => Auth::user()]) }}" class="form-group">
            <div class="input-group">
                @if (Auth::user()->tipo == 'A' || Auth::user()->tipo == 'C')
                    <select class="form-control col-3" name="apagado">
                        <option value="notDeleted" {{'notDeleted' == $apagado ? 'selected' : 'notDeleted'}} class="dropdown-item">Estampas Disponíveis</option>
                        <option value="all" {{'all' == $apagado ? 'selected' : 'all'}} class="dropdown-item">Todas as Estampas</option>
                        <option value="deleted" {{'deleted' == $apagado ? 'selected' : 'deleted'}} class="dropdown-item">Estampas Apagadas</option>
                    </select>
                @endif
                @if (Route::currentRouteName()=='estampas')
                <select class="form-control col-3" name="categoria" id="inputCategoria">
                    <option value="" selected>Todas as categorias...</option>
                    <option value="0" {{$categoria == '0' ? 'selected' : ''}}>Sem categoria</option>
                    @foreach ($categorias as $abr => $nomeCategoria)
                    <option value={{$abr}} {{$abr == $categoria ? 'selected' : ''}}>{{$nomeCategoria}}</option>
                    @endforeach
                </select>
                @endif
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
                    @can('delete', $estampa)
                        <form action="{{route('estampas.delete', ['estampa' => $estampa])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <div class="col-2 pl-0">
                                <button type="submit" class="btn btn-outline-danger"><i class="fad fa-trash"></i></button>
                            </div>
                        </form>
                    @endcan
                @else
                    @can('restore', $estampa)
                        <form action="{{route('estampas.restore', ['id' => $estampa->id])}}" method="POST">
                            @csrf
                            <div class="col-2 pl-0">
                                <button class="btn btn-outline-success"><i class="fad fa-trash-restore"></i></button>
                            </div>
                        </form>
                    @endcan
                    @can('forceDelete', $estampa)
                        <form action="{{route('estampas.forceDelete', ['id' => $estampa->id])}}" method="POST" id="forceDeleteForm{{$estampa->id}}">
                            @csrf
                            <div class="col-2 pl-0">
                                <button type="button" class="btn btn-outline-danger" onclick="forceDeleteClicked({{$estampa->id}}, '{{$estampa->nome}}')" data-toggle="modal" data-target="#forceDeleteModal"><i class="fas fa-ban"></i></button>
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

@can('forceDelete', $estampa)
    <!-- Modal -->
    <div class="modal fade" id="forceDeleteModal" tabindex="-1" role="dialog" aria-labelledby="forceDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="forceDeleteModalLabel">Apagar permanentemente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    Tem a certeza que quer apagar permanentemente a estampa <span id="estampaNomeModal"></span>?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="" id="estampaBtnSubmitModal" class="btn btn-danger">Apagar</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <script src="{{asset('js/estampas.js')}}"></script>

@endcan

@endif
@endsection
