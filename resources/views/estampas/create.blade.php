@extends('layout')
@section('title','Criar Estampa')
@section('content')


<form action="">
    @csrf
    @include('estampas.partials.create-edit')
    <div class="form-group text-center">
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        <a href="{{route('estampas.create')}}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@endsection
