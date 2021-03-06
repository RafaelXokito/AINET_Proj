
<div class="row mb-5">
    <div class="col-lg-10 mx-auto">
        <ul class="list-group shadow">
            <li class="list-group-item">
                <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                    <div class="media-body order-2 order-lg-1">
                        <h6 class="mt-0 font-weight-bold mb-2">Número de encomenda: {{$encomenda->id}}</h6>
                        <hr>
                        <span class="mt-0 font-weight-bold mb-2">
                        Método Pagamento: {{$encomenda->tipo_pagamento}}
                        </span><br>
                        <span class="mt-0 font-weight-bold mb-2">
                        {{$encomenda->tipo_pagamento == 'PAYPAL' ? 'Email de' : 'Referência para' }} Pagamento: {{$encomenda->ref_pagamento}}
                        </span><br>
                        <span class="mt-0 font-weight-bold mb-2">
                        Endereço de Entrega: {{$encomenda->endereco}}
                        </span><br>
                        <span class="mt-0 font-weight-bold mb-2">
                        NIF: {{$encomenda->nif}}
                        </span><br>
                        <span class="mt-0 font-weight-bold mb-2">
                        Notas: {{$encomenda->notas}}
                        </span><br>
                        <span class="mt-0 font-weight-bold mb-2">
                        Total: {{number_format($encomenda->preco_total,2)}} €
                        </span><br>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="row mb-5">
<div class="col-lg-10 mx-auto">

    <!-- List group-->
    <ul class="list-group shadow">

    @foreach ($encomenda->tshirts as $tshirt)

    @php
        $informacaoextra = json_decode(json_decode($tshirt->estampa, true)['informacao_extra'],true);
    @endphp
    <!-- list group item-->
    <li class="list-group-item">
        <!-- Custom content-->
        <div class="media align-items-lg-center flex-column flex-lg-row p-3">
        <div class="media-body order-2 order-lg-1">
        <h6 class="mt-0 font-weight-bold mb-2">Cor: <img id="colorInputCor" style="width: 16px; height: 16px; background-color: #{{$tshirt->cor_codigo}}" /> #{{strtoupper($tshirt->cor_codigo)}}</h6>
        <h6 class="mt-0 font-weight-bold mb-2">Tamanho: {{$tshirt->tamanho}}</h6>
        <h6 class="mt-0 font-weight-bold mb-2">Quantidade: {{$tshirt->quantidade}}</h6>

        <p class="font-italic text-muted mb-0 small">
            Posicao: {{ucfirst($informacaoextra['inputPosicao'] ?? 'Top')}}
        </p>
        <p class="font-italic text-muted mb-0 small">
            Rotação: {{$informacaoextra['inputRotacao'] ?? '0'}}º
        </p>
        <p class="font-italic text-muted mb-0 small">
            Opacidade: {{$informacaoextra['inputOpacidade'] ?? '100'}}%
        </p>
        <p class="font-italic text-muted mb-0 small">
            Zoom: {{$informacaoextra['inputZoom'] ?? '0'}}
        </p>
        <div class="d-flex align-items-center justify-content-between mt-1">
        <h6 class="font-weight-bold my-2">Preço un. {{ number_format($tshirt->preco_un,2) }}€</h6>
        <h6 class="font-weight-bold my-2">Sub-total {{ number_format($tshirt->subtotal,2) }}€</h6>
        </div>
        </div>
        @if (Route::currentRouteName()=='encomendas')
        <img src="" data-src="{{route('estampas.preview', ['estampa' => $tshirt->estampa_id, 'cor' => $tshirt->cor_codigo, 'posicao' => $informacaoextra['inputPosicao'] ?? 'top', 'rotacao' => $informacaoextra['inputRotacao'] ?? '0', 'opacidade' => $informacaoextra['inputOpacidade'] ?? '100', 'zoom' => $informacaoextra['inputZoom'] ?? '0']) }}" alt="Preview da estampa na tshirt" width="200" class="ml-lg-5 order-1 order-lg-2 preview_encomenda{{$encomenda->id}}">
        @else
        <img src="{{route('estampas.preview', ['estampa' => $tshirt->estampa_id, 'cor' => $tshirt->cor_codigo, 'posicao' => $informacaoextra['inputPosicao'] ?? 'top', 'rotacao' => $informacaoextra['inputRotacao'] ?? '0', 'opacidade' => $informacaoextra['inputOpacidade'] ?? '100', 'zoom' => $informacaoextra['inputZoom'] ?? '0']) }}" alt="Preview da estampa na tshirt" width="200" class="ml-lg-5 order-1 order-lg-2">
        @endif
        </div>
        <!-- End -->
    </li>
    <!-- End -->
    @endforeach

    </ul>
    <!-- End -->
</div>
</div>
