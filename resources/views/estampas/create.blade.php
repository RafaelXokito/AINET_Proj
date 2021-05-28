@extends('layout')
@section('title','Criar Estampa')
@section('content')

<br>
<hr>
<br>
<form method="POST" action="{{route('estampas.store')}}" class="form-group" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col">
            @include('estampas.partials.create-edit')
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('estampas.create')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
<script src="{{asset('js/estampas-create.js')}}"></script>
@endsection
