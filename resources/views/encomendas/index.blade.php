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
                <select id="inputEstado" name="inputEstado">
                    <option value="pendente">Pendente</option>
                    <option value="paga">Paga</option>
                    <option value="fechada">Fechada</option>
                    <option value="anulada">Anulada</option>
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
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($encomendas as $encomenda)
            <tr>
                <td>{{$encomenda->cliente->user->name}}</td>
                <td>
                    @can('edit', App\Models\Encomenda::class)
                        <a href="" data-toggle="modal" onclick="alterarOnClick({{$encomenda->id}}, '{{$encomenda->nome}}')" data-target="#createOrEditModal" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
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
