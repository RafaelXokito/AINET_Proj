@extends('layout')
@section('title','Estampa')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<br>
<hr>
<br>
<div class="">
    <div class="row d-flex justify-content-center">
        @include('estampas.partials.preview')
        <input id="estampa_id" value="{{$estampa->id}}" hidden>
        <input id="inputPosicao" value="{{$inputPosicao}}" hidden>
        <input id="inputRotacao" value="{{$inputRotacao}}" hidden>
        <input id="inputOpacidade" value="{{$inputOpacidade}}" hidden>
    </div>
    <div class="row text-center d-flex justify-content-center mt-3">
        <div class="form-group col-4">
            <label for="inputCor">Cor</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text  border-0" id="">
                        <img id="colorInputCor" style="width: 16px; height: 16px; background-color: #{{$cor->codigo}}" />
                    </span>
                </div>
                <select class="form-control" name="cor_codigo" id="inputCor" data-live-search="true">
                    <!--<option value="" selected>Escolher cor...</option>-->
                    @foreach ($cores as $abr => $nome)
                    <option value={{$abr}} {{$abr == old('cor_codigo', $cor->codigo) ? 'selected' : ''}}>{{$nome}}</option>
                    @endforeach
                </select>
            </div>
            @error('cor_codigo')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
    </div>

    <div class="row d-flex justify-content-center mt-5">
        <div class="form-group">
            <a href="" class="btn btn-info" data-toggle="modal" data-target="#adicionarAoCarrinhoModal">
                <i class="fa fa-shopping-cart"></i>
                Adicionar ao carrinho
            </a>
            <a href="{{route('estampas')}}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
@include('estampas.partials.modal')
<script src="{{asset('js/estampas-view.js')}}"></script>

@endsection
