@extends('layout')
@section('title','Encomendas' )
@section('content')

<br>
<hr>
<br>

<div class="row mb-3">
    <div class="col-3">
        @can('create', App\Models\Encomenda::class)
            <a href="" onclick="criarOnClick()" class="btn btn-success" role="button" data-toggle="modal" data-target="#createOrEditModal" aria-pressed="true">Nova Encomenda</a>
        @endcan
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('encomendas')}}" class="form-group">
            <div class="input-group">
                <input type="date" class="form-control" value="{{Carbon\Carbon::today()->format('Y-m-d')}}">
                <div class="input-group-addon">até</div>
                <input type="date" class="form-control" value="{{Carbon\Carbon::today()->format('Y-m-d')}}">

                <input class="form-control" id="nome" type="text" placeholder="Nome">
                <select class="custom-select" name="estado" id="estado" aria-label="estado">
                    <option value="" {{'' == $estado ? 'selected' : ''}}>Todos os estados</option>
                    <option value="pendente" {{"pendente" == $estado ? 'selected' : 'pendente'}}>Pendente</option>
                    <option value="paga" {{"paga" == $estado ? 'selected' : 'paga'}}>Paga</option>
                    <option value="fechada" {{"fechada" == $estado ? 'selected' : 'fechada'}}>Fechada</option>
                    <option value="anulada" {{"anulada" == $estado ? 'selected' : 'anulada'}}>Anulada</option>
                </select>
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
            <th>Numero Encomenda</th>
            <th>Estado</th>
            <th>Data de Criação</th>
        </tr>
    </thead>
    <tbody>
        @foreach($encomendas as $encomenda)
            <tr>
                <td>{{$encomenda->cliente->user->name}}</td>
                <td>{{$encomenda->id}}</td>
                <td>{{$encomenda->estado}}</td>
                <td>{{$encomenda->data}}</td>
                <td>
                    @can('update', App\Models\Encomenda::class)
                        <a href="" data-toggle="modal" onclick="alterarOnClick({{$encomenda->id}}, '{{$encomenda->estado}}')" data-target="#createOrEditModal" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar Estado</a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
{!! $encomendas->withQueryString()->links("pagination::bootstrap-4") !!}
</div>

<script src="{{asset('js/encomendas.js')}}"></script>
@endsection
