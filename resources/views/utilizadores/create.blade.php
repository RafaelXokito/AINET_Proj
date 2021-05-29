@extends('layout')
@section('title', 'Novo User' )
@section('content')
    <form method="POST" action="{{route('utilizadores.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('utilizadores.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('utilizadores.create')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
