@extends('layout')
@section('title','Editar Estampa')
@section('content')

<br>
<hr>
<br>
<form method="POST" action="{{route('estampas.update', ['estampa' => $estampa])}}" class="form-group" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6">
            @include('estampas.partials.create-edit')
            <div class="form-group col-6">
                <label for="inputCategoria">Cor</label>
                <select form="previewForm" class="form-control" name="cor_codigo" id="inputCategoria">
                    <option value="" selected>Escolher cor...</option>
                    @foreach ($cores as $abr => $nome)
                       <option value={{$abr}} >{{$nome}}</option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="col-6">
            @include('estampas.partials.preview')
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-5">
        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
<form id="previewForm"></form>
<script src="{{asset('js/estampas-create.js')}}"></script>
@endsection
