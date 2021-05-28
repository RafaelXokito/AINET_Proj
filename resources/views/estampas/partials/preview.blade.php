@isset($estampa)
<img class="img-fluid" src="{{route('estampas.preview', ['estampa' => $estampa, 'cor' => '7f7277'] )}}">
@endisset
