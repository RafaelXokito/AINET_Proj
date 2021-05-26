@extends('layout')
@section('content')
<h2>Utilizadores</h2>
<div class="users-area">
    @foreach($users as $user)
    <div class="user">
        <div class="user-imagem">
            <img src="{{$user->url_foto ?
                        asset('storage/fotos/' . $user->url_foto) :
                        asset('img/default_img.png') }}" alt="Imagem do user">
        </div>
        <div class="user-info-area">
        <div class="user-name">{{$>user->name}}</div>
            <div class="user-info">
                <span class="user-label"><i class="fas fa-envelope"></i></span>
                <span class="user-info-desc"><a href="mailto:{{$user->email}}">{{$user->email}}</a>
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
