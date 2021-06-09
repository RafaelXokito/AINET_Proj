@extends('layout')
@section('title','Encomendas' )
@section('content')

<br>
<hr>
<br>

<div class="row mb-3 d-flex justify-content-center">
    <div class="col-9">
        <form method="GET" action="{{route('encomendas')}}" class="form-group">
            <div class="input-group">
                <input type="date" class="form-control" name="dataInicial" value="{{$dataInicial ?? Carbon\Carbon::today()->format('Y-m-d')}}">
                <div class="input-group-prepend"><span class="input-group-text align-middle">até</span></div>
                <input type="date" class="form-control" name="dataFinal" value="{{$dataFinal ?? Carbon\Carbon::today()->format('Y-m-d')}}">
                <input class="form-control" id="nome" name="nome" type="text" value="{{$nome ?? ''}}" placeholder="Nome Cliente">
                <select class="custom-select" name="estado" id="estado" aria-label="estado">
                    <option value="" {{'' == $estado ? 'selected' : ''}}>Todos os estados</option>
                    <option value="pendente" {{"pendente" == $estado ? 'selected' : 'pendente'}}>Pendente</option>
                    <option value="paga" {{"paga" == $estado ? 'selected' : 'paga'}}>Paga</option>
                    @if (Auth::user()->tipo != 'F')
                    <option value="fechada" {{"fechada" == $estado ? 'selected' : 'fechada'}}>Fechada</option>
                    <option value="anulada" {{"anulada" == $estado ? 'selected' : 'anulada'}}>Anulada</option>
                    @endif
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

                <tr {{$encomenda->estado == 'pendente' ? 'class=table-warning' : ''}} {{$encomenda->estado == 'paga' ? 'class=table-primary' : ''}} {{$encomenda->estado == 'fechada' ? 'class=table-success' : ''}} {{$encomenda->estado == 'anulada' ? 'class=table-danger' : ''}} >
                    <td>{{$encomenda->cliente->user->name}}</td>
                    <td>{{$encomenda->id}}</td>
                    <td>{{strtoupper($encomenda->estado)}}</td>
                    <td>{{$encomenda->data}}</td>
                    <td>
                        @can('update', App\Models\Encomenda::class)
                            <a href="" data-toggle="modal" data-target="#alterarEstadoEncomendaModal{{$encomenda->id}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar Estado</a>
                            @include('encomendas.partials.modal')
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
