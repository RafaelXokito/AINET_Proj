<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\Estampa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\Debugbar\Facade as DebugBar;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class GenerateInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $encomenda = $this->data['encomenda'];

        PDF::setOptions(['dpi' => '150', 'defaultFont' => 'sans-serif']);
        view()->share('data', $this->data);
        $pdf = PDF::loadView('emails.partials.pdf_email');

        $content = $pdf->download()->getOriginalContent();
        Storage::disk('local')->put('\pdf_recibos\recibo_'.$encomenda->id.'.pdf', $content);
        return true;
    }
}
