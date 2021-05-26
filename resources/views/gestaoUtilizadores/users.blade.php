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
            <select class="custom-select" name="tipo" id="inputTipo" aria-label="Tipo">
                <option value="" {{'' == old('tipo', '') ? 'selected' : ''}}>Todos Tipos</option>
                <option value="C" {{"C" == old('tipo', "Cliente") ? 'selected' : 'C'}}>Cliente</option>
                <option value="F" {{"F" == old('tipo', "Funcionário") ? 'selected' : 'F'}}>Funcionário</option>
                <option value="A" {{"A" == old('tipo', "Administrador") ? 'selected' : 'A'}}>Administrador</option>
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
                        <img src="{{$user->url_foto ? asset('storage/fotos/' . $docente->user->url_foto) : asset('img/default_img.png') }}" alt="Foto do docente"  class="img-profile rounded-circle" style="width:40px;height:40px">
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->tipo}}</td>
                    <td>
                        @can('view', $user)
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
