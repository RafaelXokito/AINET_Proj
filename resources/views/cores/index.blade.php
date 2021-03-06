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
                    @if (!$cor->trashed())
                        @can('delete', $cor)
                        <form action="{{route('cores.delete', ['cor' => $cor])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <div class="col-2 pl-0">
                                <button type="submit" class="btn btn-outline-danger"><i class="fad fa-trash"></i></button>
                            </div>
                        </form>
                        @endcan
                    @else
                        @can('restore', $cor)
                        <form action="{{route('cores.restore', ['codigo_cor' => $cor->codigo])}}" method="POST">
                            @csrf
                            <div class="col-2 pl-0">
                                <button class="btn btn-outline-success"><i class="fad fa-trash-restore"></i></button>
                            </div>
                        </form>
                        @endcan
                        @can('forceDelete', App\Model\Cor::class)
                </td>
                <td>
                        <form action="{{route('cores.forceDelete', ['codigo_cor' => $cor->codigo])}}" method="POST" id="forceDeleteForm{{$cor->codigo}}">
                            @csrf
                            <div class="col-2 pl-0">
                                <button type="button" class="btn btn-outline-danger" onclick="forceDeleteClicked('{{$cor->codigo}}')" data-toggle="modal" data-target="#forceDeleteModal"><i class="fas fa-ban"></i></button>
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
{!! $cores->withQueryString()->links("pagination::bootstrap-4") !!}
</div>

@can('forceDelete', App\Model\Cor::class)
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
                    Tem a certeza que quer apagar permanentemente a cor #<span id="corNomeModal"></span>?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="" id="corBtnSubmitModal" class="btn btn-danger">Apagar</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endcan

@include('cores.partials.modal')

<script src="{{asset('js/cores.js')}}"></script>

@endsection
