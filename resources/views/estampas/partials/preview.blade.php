@isset($estampa)
<form action="{{route('estampas')}}" id="formPreview"></form>
<img id="previewImage" class="img-fluid" src="{{route('estampas.preview', ['estampa' => $estampa, 'cor' => $cor->codigo, 'posicao' => $inputPosicao, 'rotacao' => $inputRotacao, 'opacidade' => $inputOpacidade] )}}">
@endisset
