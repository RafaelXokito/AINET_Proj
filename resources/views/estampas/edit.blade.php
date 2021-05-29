@extends('layout')
@section('title','Editar Estampa')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<br>
<hr>
<br>
<form method="POST" action="{{route('estampas.update', ['estampa' => $estampa])}}" class="form-group" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-6">
            <input id="estampa_id" value="{{$estampa->id}}" hidden>
            <div id="changedImg" class="alert alert-info" role="alert" style="display: none">
                Para ver o preview da imagem alterada tem de guardar a estampa!
            </div>
            @include('estampas.partials.create-edit')
            <div class="row">
                <div class="form-group col">
                    <label for="inputCor">Cor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  border-0" id="">
                                <img id="colorInputCor" style="width: 16px; height: 16px; background-color: #{{$cor->codigo}}" />
                             </span>
                        </div>
                        <select form="previewForm" class="form-control" name="cor_codigo" id="inputCor">
                            <!--<option value="" selected>Escolher cor...</option>-->
                            @foreach ($cores as $abr => $nome)
                            <option value={{$abr}} >{{$nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('cor_codigo')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="inputOpacidade">Opacidade</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  border-0" id="inputOpacidadeValue">
                                100
                             </span>
                            <span class="input-group-text  border-0 rounded-right" id="">
                                <input type="range" value="100" class="form-range" id="inputOpacidade" name="inputOpacidade" onchange="inputOpacidadeChange(this.value)" >
                            </span>
                        </div>
                    </div>
                    @error('cor_codigo')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="inputPosicao">Posição</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  border-0" id="basic-addon1">
                                <span class="input-group-addon">
                                    <i id="inputPosicaoIcon" class="bi bi-align-top"></i>
                                </span>
                            </span>
                        </div>
                        <select class="form-control" style="float: left;width: initial;" id="inputPosicao">
                            <option value="top">Cima</option>
                            <option value="center">Centro</option>
                            <option value="bottom">Baixo</option>
                        </select>
                    </div>
                    @error('categoria_id')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="inputRotacao">Rotação</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  border-0" id="inputRotacaoValue">
                                0º
                             </span>
                            <span class="input-group-text  border-0 rounded-right" id="">
                                <input type="range" value="0" min="0" max="360" step="1" class="form-range" name="inputRotacao" id="inputRotacao" onchange="inputRotacaoChange(this.value)">
                            </span>
                        </div>
                    </div>
                    @error('cor_codigo')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
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
<script src="{{asset('js/estampas-edit.js')}}"></script>
@endsection
