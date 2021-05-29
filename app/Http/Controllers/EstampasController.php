<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstampaPost;
use App\Mail\SendMail;
use App\Models\Categoria;
use App\Models\Cor;
use App\Models\Cores;
use Illuminate\Http\Request;
use App\Models\Estampa;
use App\Models\Tshirt;
use App\Models\User;
use App\Policies\EstampaPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class EstampasController extends Controller
{
    public function index(User $user = null)
    {
        $qry = Estampa::query();
        $id = $user->id ?? '';
        if ($id != '') {
            $qry->where('cliente_id', '=', $user->id);
        }
        $estampas = $qry->paginate(10);
        return view('estampas.index')->withEstampas($estampas);
    }

    public function create()
    {
        $estampa = new Estampa;
        $listaCategorias = Categoria::pluck('nome', 'id');
        return view('estampas.create')
            ->withEstampa($estampa)
            ->withCategorias($listaCategorias);
    }

    public function edit(Estampa $estampa)
    {
        $listaCategorias = Categoria::pluck('nome', 'id');
        $listaCores = Cores::pluck('nome', 'codigo');
        $cor = Cores::first();
        return view('estampas.edit')
            ->withCor($cor)
            ->withCores($listaCores)
            ->withEstampa($estampa)
            ->withCategorias($listaCategorias);
    }

    public function update(Estampa $estampa)
    {
        $estampa = new Estampa;
        $listaCategorias = Categoria::pluck('nome', 'id');
        return view('estampas.edit')
            ->withEstampa($estampa)
            ->withCategorias($listaCategorias);
    }

    public function store(EstampaPost $request)
    {
        try {
            $validatedData = $request->validated();
            $estampa = new Estampa;
            $estampa->cliente_id =  Auth::user()->id;
            $estampa->categoria_id = $validatedData['categoria_id'];
            $estampa->nome = $validatedData['nome'];
            $estampa->descricao = $validatedData['descricao'];
            if ($request->hasFile('imagem_url')) {
                $estampa->imagem_url = basename(Storage::disk('local')->putFile('estampas_privadas\\', $validatedData['imagem_url']));
            }
            if ($request->has('informacao_extra')) {
                $estampa->informacao_extra = $validatedData['informacao_extra'];
            }
            $estampa->save();
            return redirect()->route('estampasUser', Auth::user())
                ->with('alert-msg', 'Estampa foi criada com sucesso!')
                ->with('alert-type', 'success');

        } catch (\Throwable $th) {
            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - PrecoController',
                'message'   =>   $th->getMessage()
            );

            Mail::to(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MAGICTSHIRTS.com'))->send(new SendMail($data));
            return redirect()->route('estampas.create')
                ->withEstampa($estampa)
                ->withInput()
                ->with('alert-msg', 'Estampa NÃO foi criada com sucesso!')
                ->with('alert-type', 'error');
        }
    }
    public function show(Estampa $estampa)
    {
        return response()->file(storage_path('app\estampas_privadas\\'.$estampa->imagem_url));
    }

    public function preview(Estampa $estampa = null, $cor, $posicao, $rotacao, $opacidade)
    {
        try {

            // create new Intervention Image
            $img = Image::make(public_path('storage\tshirt_base\\'). $cor.'.jpg');

            $width = 200; // your max width
            $height = 200; // your max height
            $watermark = Image::make(storage_path('app\estampas_privadas\\'.$estampa->imagem_url));
            $watermark->height() > $img->width() ? $width=null : $height=null;
            $watermark->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            if ($rotacao != 0) {
                $watermark->rotate($rotacao);
            }
            if ($opacidade != 100) {
                $watermark->opacity($opacidade);
            }
            $img->insert($watermark, $posicao, 0, 100);

            return $img->response('jpg');
        } catch (\Throwable $th) {
            return null;
            return response()->json([
                'success' => false,
                'responseText' => $th->getMessage(),
            ]);
        }
    }
}
