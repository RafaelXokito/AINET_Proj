@extends('layout')
@section('title', 'Novo User' )
@section('content')
    <form method="POST" action="{{route('gestaoUtilizadores.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('gestaoUtilizadores.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('gestaoUtilizadores.create')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
