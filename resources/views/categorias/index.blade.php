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
                    @can('edit', $categoria)
                        <a href="" data-toggle="modal" onclick="alterarOnClick({{$categoria->id}}, '{{$categoria->nome}}')" data-target="#createOrEditModal" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                    @endcan
                </td>
                <td>
                    @can('delete', $categoria)
                        <form action="{{route('categorias.delete', ['categoria' => $categoria])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    @endcan
                    @can('restore', $categoria)
                        <form action="{{route('categorias.restore', ['id' => $categoria])}}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-success btn-sm" value="Restaurar">
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
{!! $categorias->withQueryString()->links("pagination::bootstrap-4") !!}
</div>

@include('categorias.partials.modal')

<script src="{{asset('js/categorias.js')}}"></script>

@endsection
