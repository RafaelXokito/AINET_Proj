@extends('layout')
@section('title','Cores')
@section('content')
<br>
<hr>
<br>

<div class="row mb-3">
    <div class="col-3">
        @can('create', App\Models\User::class)
            <a href="" onclick="criarOnClick()" class="btn btn-success" role="button" data-toggle="modal" data-target="#createOrEditModal" aria-pressed="true">Nova Cor</a>
        @endcan
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('cores')}}" class="form-group">
            <div class="input-group">
                @can('isAdmin', App\Models\User::class)
                <div class="input-group-prepend">
                    <select class="rounded-left input-group-text" name="apagado">
                        <option value="notDeleted" {{'notDeleted' == $apagado ? 'selected' : 'notDeleted'}} class="dropdown-item">Cores Disponíveis</option>
                        <option value="all" {{'all' == $apagado ? 'selected' : 'all'}} class="dropdown-item">Todas as Cores</option>
                        <option value="deleted" {{'deleted' == $apagado ? 'selected' : 'deleted'}} class="dropdown-item">Cores Apagadas</option>
                    </select>
                </div>
                @endcan
                <input id="inputCodigo" name="codigo" class="input-control" placeholder="Codigo" value="{{$codigo}}">
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
            <th></th>
            <th>Código</th>
            <th>Nome</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($cores as $cor)
            <tr>
                <td class="text-center">
                    <img id="colorInputCor" style="width: 16px; height: 16px; background-color: #{{$cor->codigo}}" />
                </td>
                <td>#{{strtoupper($cor->codigo)}}</td>
                <td>{{$cor->nome}}</td>
                <td>
                    @can('edit', $cor)
                        <a href="" data-toggle="modal" onclick="alterarOnClick('{{$cor->codigo}}', '{{$cor->nome}}')" data-target="#createOrEditModal" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                    @endcan
                </td>
                <td>
                    @can('delete', $cor)
                        <form action="{{route('cores.delete', ['cor_codigo' => $cor->codigo])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    @endcan
                    @can('restore', $cor)
                        <form action="{{route('cores.restore', ['cor_codigo' => $cor->codigo])}}" method="POST">
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
{!! $cores->withQueryString()->links("pagination::bootstrap-4") !!}
</div>

@include('cores.partials.modal')

<script src="{{asset('js/cores.js')}}"></script>

@endsection
