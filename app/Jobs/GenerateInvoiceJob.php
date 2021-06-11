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
        $pdf = PDF::loadView('encomendas.partials.pdf_email');

        $content = $pdf->download()->getOriginalContent();
        Storage::disk('local')->put('\pdf_recibos\recibo_'.$encomenda->id.'.pdf', $content);
        return true;
        /*if ($this->data['message'] == 'encomenda_fechada') {

            $encomenda = $this->data['encomenda'];
            if ($this->data['message'] == 'encomenda_fechada') {

                $i = 0;
                foreach ($this->data['tshirts'] as $key => $value) {

                    $informacoesextra = json_decode($value->estampa->informacao_extra, true);
                    $estampa = Estampa ::withTrashed()->findOrFail($value->estampa->id);

                    // create new Intervention Image
                    $img = Image::make(public_path('storage\tshirt_base\\'). $value->cor_codigo.'.jpg');

                    $width = 210; // your max width
                    $height = 210; // your max heigh

                    if ($estampa->cliente_id == null) {
                        $watermark = Image::make(public_path('storage\estampas\\').$estampa->imagem_url);
                    } else {
                        $watermark = Image::make(storage_path('app\estampas_privadas\\'.$estampa->imagem_url));
                    }

                    if ($informacoesextra['inputZoom'] ?? 0 >= 0) {
                        $width = intval(($width/2) * ($informacoesextra['inputZoom'] ?? 0 +1));
                        $height = intval(($height/2) * ($informacoesextra['inputZoom'] ?? 0 +1));

                        $width > 210 ? $width=210 : false;
                        $height > 210 ? $height=210 : false;
                    } elseif ($informacoesextra['inputZoom'] ?? 0 < 0) {
                        $width = intval(($width/2) / (($informacoesextra['inputZoom'] ?? 0-1)*-1));
                        $height = intval(($height/2) / (($informacoesextra['inputZoom'] ?? 0-1)*-1));

                        $width > 210 ? $width=210 : false;
                        $height > 210 ? $height=210 : false;
                    }

                    $watermark->height() > $img->width() ? $width=null : $height=null;

                    $watermark->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $watermark->resizeCanvas($watermark->width(), $watermark->height(), 'center', false, 'rgba(0, 0, 0, 0)');

                    $watermark->rotate($informacoesextra['inputRotacao'] ?? 0);
                    $watermark->opacity($informacoesextra['inputOpacidade'] ?? 100);
                    //$watermark->resize($watermark->width()*$zoom, $watermark->height()*$zoom);

                    $img->insert($watermark, $informacoesextra['inputPosicao'] ?? 'top', 0, 100);

                    $img->save(public_path('temp'.$i++.'.jpg'));
                }

                PDF::setOptions(['dpi' => '150', 'defaultFont' => 'sans-serif']);
                view()->share('data', $this->data);
                $pdf = PDF::loadView('encomendas.partials.pdf_email');

                for ($j=0; $j < $i; $j++) {
                    File::delete(public_path('temp'.$i++.'.jpg'));
                }
                $content = $pdf->download()->getOriginalContent();
                DebugBar::info($content);
                Storage::disk('local')->put($content, '\pdf_recibos\recibo_'.$encomenda->id.'.pdf'.'.pdf', $content);
            }
        }*/
    }
}
