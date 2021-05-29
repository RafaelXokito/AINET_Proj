@isset($estampa)
<img id="previewImage" class="img-fluid" src="{{route('estampas.preview', ['estampa' => $estampa, 'cor' => $cor->codigo, 'posicao' => 'top', 'rotacao' => '0', 'opacidade' => '100'] )}}">
@endisset
