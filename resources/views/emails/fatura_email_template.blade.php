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
    @include('emails.partials.email_css')
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
                        @include('emails.partials.detalhes_email_encomenda')
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
