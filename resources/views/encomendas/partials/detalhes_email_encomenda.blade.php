<tr>
    <td class="content-cell">
      <div class="f-fallback">
        <h1>Olá {{$data['encomenda']->cliente->user->name}},</h1>
        @if ($data['encomenda']->estado == 'pendente')
            <p>Obrigado por comprar connosco. A sua encomenda está a ser processada. <br>Esta é a fatura da sua compra mais recente.</p>
        @elseif ($data['encomenda']->estado == 'paga')
            <p>Obrigado por comprar connosco. A sua encomenda está paga.</p>
        @elseif ($data['encomenda']->estado == 'fechada')
            <p>Obrigado por comprar connosco. A sua encomenda está a caminho.</p>
        @elseif ($data['encomenda']->estado == 'anulada')
            <p>Obrigado por comprar connosco. A sua encomenda está anulada. <br> Se tiver alguma dúvida contacte a nossa equipa.</p>
        @endif
        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="attributes_content">
              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="attributes_item">
                    <span class="f-fallback">
<strong>Método Pagamento:</strong> {{$data['encomenda']->tipo_pagamento}}
</span>
                  </td>
                </tr>
                <tr>
                    <td class="attributes_item">
                      <span class="f-fallback">
<strong>{{$data['encomenda']->tipo_pagamento == 'PAYPAL' ? 'Email de' : 'Referência para' }} Pagamento:</strong> {{$data['encomenda']->ref_pagamento}}
</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="attributes_item">
                      <span class="f-fallback">
<strong>Endereço de Entrega:</strong> {{$data['encomenda']->endereco}}
</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="attributes_item">
                      <span class="f-fallback">
<strong>NIF:</strong> {{$data['encomenda']->nif}}
</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="attributes_item">
                      <span class="f-fallback">
<strong>Notas:</strong> {{$data['encomenda']->notas}}
</span>
                    </td>
                  </tr>
                  <tr>
                    <td width="80%" class="purchase_footer" valign="middle">
                      <p class="f-fallback purchase_total purchase_total--label">Total</p>
                    </td>
                    <td width="20%" class="purchase_footer" valign="middle">
                      <p class="f-fallback purchase_total">{{number_format($data['encomenda']->preco_total,2)}} €</p>
                    </td>
                  </tr>
              </table>
            </td>
          </tr>
        </table>
        <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <h3>Número de encomenda: {{$data['encomenda']->id}}</h3> <!--Devia ser o número de fatura, mas não é implementável-->
            </td>
            <td>
              <h3 class="align-right">{{date('d-M-Y', strtotime($data['encomenda']->data))}}</h3>
            </td>
          </tr>
        </table>
        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <th></th>
                <th>
                  <p class="f-fallback">Produto</p>
                </th>
                <th>
                  <p class="f-fallback">Quantidade</p>
                </th>
                <th>
                  <p class="f-fallback">Tamanho</p>
                </th>
                <th>
                  <p class="f-fallback">Cor</p>
                </th>
                <th>
                  <p class="f-fallback">Preço</p>
                </th>
            </tr>
            @foreach ($data['tshirts'] as $tshirt)
            @php
            $informacoesextra = json_decode($tshirt->estampa->informacao_extra, true);
            @endphp
            <tr>

            <td class="purchase_item">
                <span class="f-fallback">
                    <img id="previewImage{{$tshirt->id}}" width="70" class="img-fluid rounded shadow-sm" src="{{route('estampas.preview', ['estampa' => $tshirt->estampa->id, 'cor' => $tshirt->cor_codigo, 'posicao' => $informacoesextra['inputPosicao'] ?? 'top', 'rotacao' => $informacoesextra['inputRotacao'] ?? '0', 'opacidade' => $informacoesextra['inputOpacidade'] ?? '100', 'zoom' => $informacoesextra['inputZoom'] ?? '0']) }}">
                </span>
            </td>
            <td class="purchase_item"><span class="f-fallback">{{$tshirt->estampa->nome}}</span></td>
            <td class="purchase_item"><span class="f-fallback">{{$tshirt->quantidade}}</span></td>
            <td class="purchase_item"><span class="f-fallback">{{$tshirt->tamanho}}</span></td>
            <td class="purchase_item"><span class="f-fallback"><img style="width: 16px; height: 16px; background-color: #{{$tshirt->cor_codigo}}" /></span></td>
            <td class="purchase_item"><span class="f-fallback">{{number_format($tshirt->preco_un,2)}} €</span></td>
            </tr>
            @endforeach

            </table>
            <table width="100%">
                <tr>
                <td width="80%" class="purchase_footer" valign="middle">
                    <p class="f-fallback purchase_total purchase_total--label">Total</p>
                </td>
                <td width="20%" class="purchase_footer" valign="middle">
                    <p class="f-fallback purchase_total">{{number_format($data['encomenda']->preco_total,2)}} €</p>
                </td>
                </tr>
            </table>
            <div class="container d-flex justify-content-center">
                <div class="row bs-wizard" style="border-bottom:0;">

                    <div class="col-xs-3 bs-wizard-step {{$data['encomenda']->estado == 'pendente' ? 'active' : ''}} {{$data['encomenda']->estado == 'paga' ? 'complete' : ''}} {{$data['encomenda']->estado == 'fechada' ? 'complete' : ''}} {{$data['encomenda']->estado == 'anulada' ? 'complete' : ''}}">
                      <div class="text-center bs-wizard-stepnum"><i class="fad fa-stopwatch"></i></div>
                      <div class="progress"><div class="progress-bar {{$data['encomenda']->estado == 'anulada' ? 'progress-bar-anulada' : ''}}"></div></div>
                      <a href="#" class="bs-wizard-dot {{$data['encomenda']->estado == 'anulada' ? 'bs-wizard-dot-anulado' : ''}}"></a>
                      <div class="bs-wizard-info text-center mx-5">Pendente</div>
                    </div>

                    <div class="col-xs-3 bs-wizard-step {{$data['encomenda']->estado == 'pendente' ? 'disabled' : ''}} {{$data['encomenda']->estado == 'paga' ? 'active' : ''}} {{$data['encomenda']->estado == 'fechada' ? 'complete' : ''}} {{$data['encomenda']->estado == 'anulada' ? 'complete' : ''}}">
                      <div class="text-center bs-wizard-stepnum"><i class="fad fa-euro-sign"></i></div>
                      <div class="progress"><div class="progress-bar {{$data['encomenda']->estado == 'anulada' ? 'progress-bar-anulada' : ''}}"></div></div>
                      <a href="#" class="bs-wizard-dot {{$data['encomenda']->estado == 'anulada' ? 'bs-wizard-dot-anulado' : ''}}"></a>
                      <div class="bs-wizard-info text-center mx-5">Paga</div>
                    </div>
                    <div class="col-xs-3 bs-wizard-step {{$data['encomenda']->estado == 'pendente' ? 'disabled' : ''}} {{$data['encomenda']->estado == 'paga' ? 'disabled' : ''}} {{$data['encomenda']->estado == 'fechada' ? 'active' : ''}} {{$data['encomenda']->estado == 'anulada' ? 'complete' : ''}}">
                      <div class="text-center bs-wizard-stepnum"><i class="fad fa-box-full"></i></div>
                      <div class="progress"><div class="progress-bar {{$data['encomenda']->estado == 'anulada' ? 'progress-bar-anulada' : ''}}"></div></div>
                      <a href="#" class="bs-wizard-dot {{$data['encomenda']->estado == 'anulada' ? 'bs-wizard-dot-anulado' : ''}}"></a>
                      <div class="bs-wizard-info text-center mx-5">Fechada</div>
                    </div>
                    @if ($data['encomenda']->estado == 'anulada')
                    <div class="col-xs-3 bs-wizard-step {{$data['encomenda']->estado == 'pendente' ? 'disabled' : ''}} {{$data['encomenda']->estado == 'paga' ? 'disabled' : ''}} {{$data['encomenda']->estado == 'fechada' ? 'disabled' : ''}} {{$data['encomenda']->estado == 'anulada' ? 'active' : ''}}">
                      <div class="text-center bs-wizard-stepnum"><i class="fad fa-lock"></i></div>
                      <div class="progress"><div class="progress-bar progress-bar-anulada"></div></div>
                      <a href="#" class="bs-wizard-dot bs-wizard-dot-anulado"></a>
                      <div class="bs-wizard-info text-center mx-5">Anulada</div>
                    </div>
                    @endif
                </div>
            </div>
            </div>
        </table>
          </tr>

