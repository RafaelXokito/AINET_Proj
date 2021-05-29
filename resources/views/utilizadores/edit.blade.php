@extends('layout')
@section('title','Alterar User' )
@section('content')
    <form method="POST" action="{{route('utilizadores.update', ['user' => $user]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{$user->id}}">
        @include('utilizadores.partials.create-edit')
        @isset($user->foto_url)
            <div class="form-group">
                <img src="{{$user->foto_url ? asset('storage/fotos/' . $user->foto_url) : asset('img/default_img.png') }}"
                     alt="Foto do user"  class="img-profile"
                     style="max-width:100%">
            </div>
        @endisset
        <div class="form-group text-right">
            @isset($user->foto_url)
                @can('update', $user)
                    <button type="submit" class="btn btn-danger" name="deletefoto" form="form_delete_photo">Apagar Foto</button>
                @endcan
            @endisset
            @can('update', $user)
                <button type="submit" class="btn btn-success" name="ok">Save</button>
            @endcan
            <a href="{{route('utilizadores.edit', ['user' => $user]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <form id="form_delete_photo" action="{{route('utilizadores.foto.destroy', ['user' => $user])}}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection
