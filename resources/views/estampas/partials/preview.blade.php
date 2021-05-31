@isset($estampa)
<input value="{{route('estampas')}}" id="formPreview" hidden>
<img id="previewImage" class="img-fluid" src="{{route('estampas.preview', ['estampa' => $estampa, 'cor' => $cor->codigo, 'posicao' => $inputPosicao, 'rotacao' => $inputRotacao, 'opacidade' => $inputOpacidade] )}}">
@endisset
