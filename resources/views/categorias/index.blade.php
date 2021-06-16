@extends('layout')
@section('title','Categorias')
@section('content')
<br>
<hr>
<br>

<div class="row mb-3">
    <div class="col-3">
        @can('create', App\Models\Categoria::class)
            <a href="" onclick="criarOnClick()" class="btn btn-success" role="button" data-toggle="modal" data-target="#createOrEditModal" aria-pressed="true">Nova Categoria</a>
        @endcan
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('categorias')}}" class="form-group">
            <div class="input-group">
                @can('isAdmin', App\Models\User::class)
                <div class="input-group-prepend">
                    <select class="rounded-left input-group-text" name="apagado">
                        <option value="notDeleted" {{'notDeleted' == $apagado ? 'selected' : 'notDeleted'}} class="dropdown-item">Categorias Disponíveis</option>
                        <option value="all" {{'all' == $apagado ? 'selected' : 'all'}} class="dropdown-item">Todas as Categorias</option>
                        <option value="deleted" {{'deleted' == $apagado ? 'selected' : 'deleted'}} class="dropdown-item">Categorias Apagadas</option>
                    </select>
                </div>
                @endcan
                <input id="inputNome" name="nome" class="input-control" placeholder="Nome" value="{{$nome}}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($categorias as $categoria)
            <tr>
                <td>{{$categoria->nome}}</td>
                <td>
                    @can('edit', App\Models\Categoria::class)
                        <a href="" data-toggle="modal" onclick="alterarOnClick({{$categoria->id}}, '{{$categoria->nome}}')" data-target="#createOrEditModal" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                    @endcan
                </td>
                <td>
                    @if (!$categoria->trashed())
                        @can('delete', App\Models\Categoria::class)
                            <form action="{{route('categorias.delete', ['categoria' => $categoria])}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <div class="col-2 pl-0">
                                    <button type="submit" class="btn btn-outline-danger"><i class="fad fa-trash"></i></button>
                                </div>
                            </form>
                        @endcan
                    @else
                        @can('restore', App\Models\Categoria::class)
                            <form action="{{route('categorias.restore', ['id' => $categoria])}}" method="POST">
                                @csrf
                                <div class="col-2 pl-0">
                                    <button class="btn btn-outline-success"><i class="fad fa-trash-restore"></i></button>
                                </div>
                            </form>
                        @endcan
                        @can('forceDelete', App\Model\Categoria::class)
                </td>
                <td>
                        <form action="{{route('categorias.forceDelete', ['id' => $categoria->id])}}" method="POST" id="forceDeleteForm{{$categoria->id}}">
                            @csrf
                            <div class="col-2 pl-0">
                                <button type="button" class="btn btn-outline-danger" onclick="forceDeleteClicked('{{$categoria->id}}', '{{$categoria->nome}}')" data-toggle="modal" data-target="#forceDeleteModal"><i class="fas fa-ban"></i></button>
                            </div>
                        </form>
                        @endcan
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
{!! $categorias->withQueryString()->links("pagination::bootstrap-4") !!}
</div>

@can('forceDelete', App\Model\Categoria::class)
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
                    Tem a certeza que quer apagar permanentemente a categoria <span id="categoriaNomeModal"></span>?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="" id="categoriaBtnSubmitModal" class="btn btn-danger">Apagar</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endcan

@include('categorias.partials.modal')

<script src="{{asset('js/categorias.js')}}"></script>

@endsection
