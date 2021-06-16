<?php

namespace App\Mail;

use App\Models\Estampa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //->attachFromStorage('pdf_recibos/recibo_'.$this->data['encomenda']->id.'.pdf');

        //Fatura build
        if ($this->data['message'] == 'fatura') {
            return $this->from(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MagicTshirt.pt'))->subject(env('APP_NAME', 'fallback_app_name').' Automatic Email')->view('emails.fatura_email_template')->with('data', $this->data);
        }
        if ($this->data['message'] == 'encomenda_paga') {
            return $this->from(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MagicTshirt.pt'))->subject(env('APP_NAME', 'fallback_app_name').' Automatic Email')->view('emails.informacao_email_template')->with('data', $this->data);
        }
        if ($this->data['message'] == 'encomenda_fechada') {
            return $this->from(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MagicTshirt.pt'))->subject(env('APP_NAME', 'fallback_app_name').' Automatic Email')->attachFromStorage('pdf_recibos\recibo_'.$this->data['encomenda']->id.'.pdf')->view('emails.informacao_email_template')->with('data', $this->data);
        }
        return $this->from(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MagicTshirt.pt'))->subject(env('APP_NAME', 'fallback_app_name').' Automatic Email')->view('emails.dynamic_email_template')->with('data', $this->data);
    }
}
