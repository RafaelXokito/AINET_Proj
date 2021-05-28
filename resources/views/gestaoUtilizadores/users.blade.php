@extends('layout')
@section('title','Users' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        @can('create', App\Models\User::class)
            <a href="{{route('gestaoUtilizadores.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo User</a>
        @endcan
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('gestaoUtilizadores')}}" class="form-group">
            <div class="input-group">
                @can('viewAny', App\Models\User::class)
                <select class="input-group-prepend" name="apagado">
                    <option value="all" {{'all' == 'apagado' ? 'selected' : 'all'}} class="dropdown-item">Todos Utilizadores</option>
                    <option value="notDeleted" {{'notDeleted' == 'apagado' ? 'selected' : 'notDeleted'}} class="dropdown-item">Utilizadores Disponíveis</option>
                    <option value="deleted" {{'deleted' == 'apagado' ? 'selected' : 'deleted'}} class="dropdown-item">Utilizadores Apagados</option>
                </select>
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
                            <a href="{{route('gestaoUtilizadores.edit', ['user' => $user])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
                        @endcan
                    </td>
                    <td>
                        @can('delete', $user)
                            <form action="{{route('gestaoUtilizadores.destroy', ['user' => $user])}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $users->links("pagination::bootstrap-4") !!}
@endsection
