@extends('layout')
@section('title','Users' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        @can('create', App\Models\User::class)
            <a href="{{route('utilizadores.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo User</a>
        @endcan
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('utilizadores')}}" class="form-group">
            <div class="input-group">
                @can('viewAny', App\Models\User::class)
                <div class="input-group-prepend">
                    <select class="rounded-left input-group-text" name="apagado">
                        <option value="notDeleted" {{'notDeleted' == $apagado ? 'selected' : 'notDeleted'}} class="dropdown-item">Utilizadores Disponíveis</option>
                        <option value="all" {{'all' == $apagado ? 'selected' : 'all'}} class="dropdown-item">Todos Utilizadores</option>
                        <option value="deleted" {{'deleted' == $apagado ? 'selected' : 'deleted'}} class="dropdown-item">Utilizadores Apagados</option>
                    </select>
                </div>
                @endcan
            <select class="custom-select" name="tipo" id="tipo" aria-label="tipo">
                <option value="" {{'' == $tipo ? 'selected' : ''}}>Todos Tipos</option>
                <option value="C" {{"C" == $tipo ? 'selected' : 'C'}}>Cliente</option>
                <option value="F" {{"F" == $tipo ? 'selected' : 'F'}}>Funcionário</option>
                <option value="A" {{"A" == $tipo ? 'selected' : 'A'}}>Administrador</option>
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
                <th></th>
                <th>Nome</th>
                <th>Tipo</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr {{$user->admin ? 'class=table-success' : ''}}>
                    <td>
                        <img src="{{$user->foto_url ? asset('storage/fotos/' . $user->foto_url) : asset('img/default_img.png') }}" alt="Foto do docente"  class="img-profile rounded-circle" style="width:40px;height:40px">
                    </td>
                    <td>{{$user->name}}</td>
                    @if ($user->tipo == 'C')
                        <td>Cliente</td>
                    @elseif ($user->tipo == 'F')
                        <td>Funcionário</td>
                    @elseif ($user->tipo == 'A')
                        <td>Administrador</td>
                    @endif
                    <td>
                        @can('edit', $user)
                            <a href="{{route('utilizadores.edit', ['user' => $user])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                        @endcan
                        @if ($user->tipo == 'C')
                            <form method="POST" action="{{route('utilizadores.updateBloquear', ['user' => $user]) }}" class="form-group" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning btn-sm" role="button" aria-pressed="true">{{$user->bloqueado == 0 ? 'Bloquear' : 'Desbloquear'}}</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if (!$user->trashed())
                        @can('delete', $user)
                        <form action="{{route('utilizadores.destroy', ['user' => $user])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <div class="col-2 pl-0">
                                <button type="submit" class="btn btn-outline-danger"><i class="fad fa-trash"></i></button>
                            </div>
                        </form>
                        @endcan
                    @else
                        @can('restore', $user)
                        <form action="{{route('utilizadores.restore', ['id' => $user->id])}}" method="POST">
                            @csrf
                            <div class="col-2 pl-0">
                                <button class="btn btn-outline-success"><i class="fad fa-trash-restore"></i></button>
                            </div>
                        </form>
                        @endcan
                        @can('forceDelete', App\Model\User::class)
                    </td>
                    <td>
                            <form action="{{route('categorias.forceDelete', ['id' => $user->id])}}" method="POST" id="forceDeleteForm{{$user->id}}">
                                @csrf
                                <div class="col-2 pl-0">
                                    <button type="button" class="btn btn-outline-danger" onclick="forceDeleteClicked('{{$user->id}}', '{{$user->nome}}')" data-toggle="modal" data-target="#forceDeleteModal"><i class="fas fa-ban"></i></button>
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
        {!! $users->withQueryString()->links("pagination::bootstrap-4") !!}
    </div>


@can('forceDelete', App\Model\User::class)
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
                Tem a certeza que quer apagar permanentemente o utilizador <span id="usersNomeModal"></span>?
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" form="" id="usersBtnSubmitModal" class="btn btn-danger">Apagar</button>
        </form>
        </div>
    </div>
    </div>
</div>
@endcan

<script src="{{asset('js/users.js')}}"></script>


@endsection
