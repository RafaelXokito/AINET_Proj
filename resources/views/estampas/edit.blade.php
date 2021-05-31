@extends('layout')
@section('title','Editar Estampa')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<br>
<hr>
<br>
<form method="POST" action="{{route('estampas.update', ['estampa' => $estampa])}}" id="formUpdate" class="form-group" enctype="multipart/form-data">
    @csrf
    @method('PUT')
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
                        <select form="formUpdate" class="form-control" name="cor_codigo" id="inputCor">
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
                <div class="form-group col-6">
                    <label for="inputOpacidade">Opacidade</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text  border-0" id="inputOpacidadeValue">
                                {{old('inputOpacidade', $inputOpacidade) ? : '100'}}%
                             </span>
                            <span class="input-group-text  border-0 rounded-right" id="">
                                <input type="range" value="{{old('inputOpacidade', $inputOpacidade) ?? '100'}}" class="form-range" id="inputOpacidade" name="inputOpacidade" oninput="inputOpacidadeOnInput(this.value)" onchange="inputOpacidadeChange(this.value)" >
                            </span>
                        </div>
                    </div>
                    @error('inputOpacidade')
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
                                    @switch(old('inputPosicao',$inputPosicao ?? ''))
                                        @case('top')
                                            <i id="inputPosicaoIcon" class="bi bi-align-top"></i>
                                            @break
                                        @case('center')
                                            <i id="inputPosicaoIcon" class="bi bi-align-center"></i>
                                            @break
                                        @case('bottom')
                                            <i id="inputPosicaoIcon" class="bi bi-align-bottom"></i>
                                            @break
                                        @default
                                            <i id="inputPosicaoIcon" class="bi bi-align-top"></i>
                                    @endswitch
                                </span>
                            </span>
                        </div>
                        <select class="form-control" style="float: left;width: initial;" name="inputPosicao" id="inputPosicao">
                            <option value="top" {{old('inputPosicao',$inputPosicao ?? '')=='top'?'selected':''}}>Cima</option>
                            <option value="center" {{old('inputPosicao',$inputPosicao ?? '')=='center'?'selected':''}}>Centro</option>
                            <option value="bottom" {{old('inputPosicao',$inputPosicao ?? '')=='bottom'?'selected':''}}>Baixo</option>
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
                                {{old('inputRotacao', $inputRotacao) ? : '0'}}º
                             </span>
                            <span class="input-group-text  border-0 rounded-right" id="">
                                <input type="range" value="{{old('inputRotacao', $inputRotacao) ?? '0'}}" min="0" max="360" step="1" class="form-range" name="inputRotacao" id="inputRotacao" oninput="inputRotacaoOnInput(this.value)" onchange="inputRotacaoChange(this.value)">
                            </span>
                        </div>
                    </div>
                    @error('inputRotacao')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-6">
            @include('estampas.partials.preview')
        </div>
    </div>
    <hr>
    <div class="row d-flex justify-content-center mt-5 text-center">
        <div class="form-group col-4">
            <label for="inputCor">Cor da t-shirt</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text  border-0" id="">
                        <img id="colorInputCor" style="width: 16px; height: 16px; background-color: #{{$cor->codigo}}" />
                    </span>
                </div>
                <select form="formUpdate" class="form-control" name="cor_codigo" id="inputCor">
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
    <div class="row d-flex justify-content-center">
        <div class="form-group">
            <button type="submit" form="formUpdate" class="btn btn-success" name="ok">Guardar</button>
            @cannot('isStaff', App\Models\User::class)
                <a href="" onclick="adicionarAoCarrinhoClick()" class="btn btn-info" data-toggle="modal" data-target="#adicionarAoCarrinhoModal">
                    <i class="fa fa-shopping-cart"></i>
                    Adicionar ao carrinho
                </a>
            @endcannot

            <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>
@include('estampas.partials.modal')
<script src="{{asset('js/estampas-edit.js')}}"></script>
@endsection
