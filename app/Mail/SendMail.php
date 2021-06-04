<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        //Fatura build
        if ($this->data['message'] == 'fatura') {
            return $this->from(env('DEVELOPER_MAIL_USERNAME', 'fallback_DEVELOPER_MAIL_USERNAME'))->subject(env('APP_NAME', 'fallback_app_name').' Automatic Email')->view('pages.dynamic_email_template')->with('data', $this->data);
        }
        return $this->from(env('DEVELOPER_MAIL_USERNAME', 'fallback_DEVELOPER_MAIL_USERNAME'))->subject(env('APP_NAME', 'fallback_app_name').' Automatic Email')->view('pages.dynamic_email_template')->with('data', $this->data);
    }
}
