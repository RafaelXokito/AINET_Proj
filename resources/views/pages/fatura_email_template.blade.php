<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title></title>
    <link href="{{ asset('css/emailFatura.css') }}" rel="stylesheet">
    <style type="text/css">
        @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");

body {
    width: 100% !important;
    height: 100%;
    margin: 0;
    -webkit-text-size-adjust: none;
}

a {
    color: #3869D4;
}

a img {
    border: none;
}

td {
    word-break: break-word;
}

.preheader {
    display: none !important;
    visibility: hidden;
    mso-hide: all;
    font-size: 1px;
    line-height: 1px;
    max-height: 0;
    max-width: 0;
    opacity: 0;
    overflow: hidden;
}
/* Type ------------------------------ */

body,
td,
th {
    font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
}

h1 {
    margin-top: 0;
    color: #333333;
    font-size: 22px;
    font-weight: bold;
    text-align: left;
}

h2 {
    margin-top: 0;
    color: #333333;
    font-size: 16px;
    font-weight: bold;
    text-align: left;
}

h3 {
    margin-top: 0;
    color: #333333;
    font-size: 14px;
    font-weight: bold;
    text-align: left;
}

td,
th {
    font-size: 16px;
}

p,
ul,
ol,
blockquote {
    margin: .4em 0 1.1875em;
    font-size: 16px;
    line-height: 1.625;
}

p.sub {
    font-size: 13px;
}
/* Utilities ------------------------------ */

.align-right {
    text-align: right;
}

.align-left {
    text-align: left;
}

.align-center {
    text-align: center;
}
/* Buttons ------------------------------ */

.button {
    background-color: #3869D4;
    border-top: 10px solid #3869D4;
    border-right: 18px solid #3869D4;
    border-bottom: 10px solid #3869D4;
    border-left: 18px solid #3869D4;
    display: inline-block;
    color: #FFF;
    text-decoration: none;
    border-radius: 3px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
    -webkit-text-size-adjust: none;
    box-sizing: border-box;
}

.button--green {
    background-color: #22BC66;
    border-top: 10px solid #22BC66;
    border-right: 18px solid #22BC66;
    border-bottom: 10px solid #22BC66;
    border-left: 18px solid #22BC66;
}

.button--red {
    background-color: #FF6136;
    border-top: 10px solid #FF6136;
    border-right: 18px solid #FF6136;
    border-bottom: 10px solid #FF6136;
    border-left: 18px solid #FF6136;
}

@media only screen and (max-width: 500px) {
    .button {
    width: 100% !important;
    text-align: center !important;
    }
}
/* Attribute list ------------------------------ */

.attributes {
    margin: 0 0 21px;
}

.attributes_content {
    background-color: #F4F4F7;
    padding: 16px;
}

.attributes_item {
    padding: 0;
}
/* Related Items ------------------------------ */

.related {
    width: 100%;
    margin: 0;
    padding: 25px 0 0 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
}

.related_item {
    padding: 10px 0;
    color: #CBCCCF;
    font-size: 15px;
    line-height: 18px;
}

.related_item-title {
    display: block;
    margin: .5em 0 0;
}

.related_item-thumb {
    display: block;
    padding-bottom: 10px;
}

.related_heading {
    border-top: 1px solid #CBCCCF;
    text-align: center;
    padding: 25px 0 10px;
}
/* Discount Code ------------------------------ */

.discount {
    width: 100%;
    margin: 0;
    padding: 24px;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    background-color: #F4F4F7;
    border: 2px dashed #CBCCCF;
}

.discount_heading {
    text-align: center;
}

.discount_body {
    text-align: center;
    font-size: 15px;
}
/* Social Icons ------------------------------ */

.social {
    width: auto;
}

.social td {
    padding: 0;
    width: auto;
}

.social_icon {
    height: 20px;
    margin: 0 8px 10px 8px;
    padding: 0;
}
/* Data table ------------------------------ */

.purchase {
    width: 100%;
    margin: 0;
    padding: 35px 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
}

.purchase_content {
    width: 100%;
    margin: 0;
    padding: 25px 0 0 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
}

.purchase_item {
    padding: 10px 0;
    color: #51545E;
    font-size: 15px;
    line-height: 18px;
}

.purchase_heading {
    padding-bottom: 8px;
    border-bottom: 1px solid #EAEAEC;
}

.purchase_heading p {
    margin: 0;
    color: #85878E;
    font-size: 12px;
}

.purchase_footer {
    padding-top: 15px;
    border-top: 1px solid #EAEAEC;
}

.purchase_total {
    margin: 0;
    text-align: right;
    font-weight: bold;
    color: #333333;
}

.purchase_total--label {
    padding: 0 15px 0 0;
}

body {
    background-color: #F4F4F7;
    color: #51545E;
}

p {
    color: #51545E;
}

p.sub {
    color: #6B6E76;
}

.email-wrapper {
    width: 100%;
    margin: 0;
    padding: 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    background-color: #F4F4F7;
}

.email-content {
    width: 100%;
    margin: 0;
    padding: 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
}
/* Masthead ----------------------- */

.email-masthead {
    padding: 25px 0;
    text-align: center;
}

.email-masthead_logo {
    width: 94px;
}

.email-masthead_name {
    font-size: 16px;
    font-weight: bold;
    color: #A8AAAF;
    text-decoration: none;
    text-shadow: 0 1px 0 white;
}
/* Body ------------------------------ */

.email-body {
    width: 100%;
    margin: 0;
    padding: 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    background-color: #FFFFFF;
}

.email-body_inner {
    width: 570px;
    margin: 0 auto;
    padding: 0;
    -premailer-width: 570px;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    background-color: #FFFFFF;
}

.email-footer {
    width: 570px;
    margin: 0 auto;
    padding: 0;
    -premailer-width: 570px;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    text-align: center;
}

.email-footer p {
    color: #6B6E76;
}

.body-action {
    width: 100%;
    margin: 30px auto;
    padding: 0;
    -premailer-width: 100%;
    -premailer-cellpadding: 0;
    -premailer-cellspacing: 0;
    text-align: center;
}

.body-sub {
    margin-top: 25px;
    padding-top: 25px;
    border-top: 1px solid #EAEAEC;
}

.content-cell {
    padding: 35px;
}
/*Media Queries ------------------------------ */

@media only screen and (max-width: 600px) {
    .email-body_inner,
    .email-footer {
    width: 100% !important;
    }
}

@media (prefers-color-scheme: dark) {
    body,
    .email-body,
    .email-body_inner,
    .email-content,
    .email-wrapper,
    .email-masthead,
    .email-footer {
    background-color: #333333 !important;
    color: #FFF !important;
    }
    p,
    ul,
    ol,
    blockquote,
    h1,
    h2,
    h3,
    span,
    .purchase_item {
    color: #FFF !important;
    }
    .attributes_content,
    .discount {
    background-color: #222 !important;
    }
    .email-masthead_name {
    text-shadow: none !important;
    }
}

:root {
    color-scheme: light dark;
    supported-color-schemes: light dark;
}

    </style>
    <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
  </head>
  <body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <h1>Olá {{$data['encomenda']->cliente->user->name}},</h1>
                        <p>Obrigado por comprar connosco. A sua encomenda está a ser processáda. <br>Esta é a fatura da sua compra mais recente.</p>
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
                        </table>
                          </tr>
                        </table>
                        <p>Se você tem qualquer questão sobre esta fatura, simples responda a este email ou contacte-nos <a href="mailto:{{env('MAIL_USERNAME')}}?subject = Problemas com a encomenda (PENDENTE) {{$data['encomenda']->id}}&body = <Descreva o seu problema>">equipa de suporte</a> para ajuda.</p>
                        <p>Cumprimentos,
                          <br>A equipa {{env('APP_NAME','MagicTshirts')}}</p>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell" align="center">
                      <p class="f-fallback sub align-center">&copy; 2021 {{env('APP_NAME','MagicTshirts')}}. All rights reserved.</p>
                      <p class="f-fallback sub align-center">
                        {{env('APP_NAME','MagicTshirts')}}
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
