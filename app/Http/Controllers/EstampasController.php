<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstampaPost;
use App\Mail\SendMail;
use App\Models\Categoria;
use App\Models\Cor;
use Illuminate\Http\Request;
use App\Models\Estampa;
use App\Models\Preco;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class EstampasController extends Controller
{
    public function index(Request $request, User $user = null)
    {

        $nomeSelected = $request->nome ?? '';
        $descricaoSelected = $request->descricao ?? '';
        $categoriaSelected = $request->categoria ?? '';
        $listaCategorias = Categoria::orderBy('nome')->pluck('nome', 'id');

        $qry = Estampa::query();
        $id = $user->id ?? '';
        if ($id != '') {
            $qry->where('cliente_id', '=', $user->id);
        }
        if ($nomeSelected != '') {
            $qry->where('nome', 'LIKE', '%'.$request->nome.'%');
        }
        if ($descricaoSelected != '') {
            $qry->where('descricao', 'LIKE', '%'.$request->descricao.'%');
        }
        if ($categoriaSelected != '') {
            if ($categoriaSelected == 0) {
                $qry->whereNull('categoria_id');
            } else {
                $qry->where('categoria_id', '=', $categoriaSelected);
            }
        }
        $estampas = $qry->paginate(10);

        return view('estampas.index')
            ->withDescricao($descricaoSelected)
            ->withNome($nomeSelected)
            ->withCategoria($categoriaSelected)
            ->withCategorias($listaCategorias)
            ->withEstampas($estampas);
    }

    public function create()
    {
        $estampa = new Estampa;
        $listaCategorias = Categoria::orderBy('nome')->pluck('nome', 'id');
        return view('estampas.create')
            ->withEstampa($estampa)
            ->withCategorias($listaCategorias);
    }

    public function edit(Estampa $estampa)
    {
        $listaCategorias = Categoria::orderBy('nome')->pluck('nome', 'id');
        $listaCores = Cor::pluck('nome', 'codigo');
        $cor = Cor::first();
        $precos = Preco::first();

        $estampa = Estampa::findOrFail($estampa->id);

        $inputPosicao = 'top';
        $inputRotacao = '0';
        $inputOpacidade = '100';


        if ($estampa->informacao_extra != null) {
            $result = json_decode($estampa->informacao_extra, true);

            $cor = Cor::where('codigo', $result['cor_codigo'])->get()->first();
            $inputPosicao = $result['inputPosicao'];
            $inputRotacao = $result['inputRotacao'];
            $inputOpacidade = $result['inputOpacidade'];

        }



        if ($estampa->cliente_id == null && Auth::user()->tipo != 'A') {
            return view('estampas.view')
                ->withPrecos($precos)
                ->withInputPosicao($inputPosicao)
                ->withInputRotacao($inputRotacao)
                ->withInputOpacidade($inputOpacidade)
                ->withCor($cor)
                ->withCores($listaCores)
                ->withEstampa($estampa)
                ->withCategorias($listaCategorias);
        } else {
            return view('estampas.edit')
                ->withPrecos($precos)
                ->withInputPosicao($inputPosicao)
                ->withInputRotacao($inputRotacao)
                ->withInputOpacidade($inputOpacidade)
                ->withCor($cor)
                ->withCores($listaCores)
                ->withEstampa($estampa)
                ->withCategorias($listaCategorias);
        }
    }

    public function update(Request $request, Estampa $estampa)
    {
        $cor = Cor::first();
        $precos = Preco::first();
        $listaCategorias = Categoria::orderBy('nome')->pluck('nome', 'id');
        $listaCores = Cor::pluck('nome', 'codigo');
        try {
            $validatedData = $request->validate([
                'categoria_id' => 'nullable|exists:categorias,id',
                'nome' => 'required|max:255',
                'descricao' => 'required|string',
                'cor_codigo' => 'exists:cores,codigo',
                'inputOpacidade' => 'min:0|max:100',
                'inputPosicao' => 'in:top,center,bottom',
                'inputRotacao' => 'min:0|max:360',
                'imagem_url' => 'image|max:8192',
            ]);

            $cor = Cor::where('codigo', $validatedData['cor_codigo'])->get()->first();
            $estampa = Estampa::findOrFail($estampa->id);

            $estampa->categoria_id = $validatedData['categoria_id'];
            $estampa->nome = $validatedData['nome'];
            $estampa->descricao = $validatedData['descricao'];

            if (Auth::user()->tipo != 'A') {

                if ($request->has('imagem_url')) {
                    Storage::delete('estampas_privadas/'.$estampa->imagem_url);
                    $estampa->imagem_url = basename(Storage::disk('local')->putFileAs('estampas_privadas\\', $validatedData['imagem_url'], $estampa->id . "_" . uniqid() . '.png'));
                }
            } else {
                if ($request->has('imagem_url')) {
                    Storage::disk('public')->delete('estampas/'.$estampa->imagem_url);
                    $estampa->imagem_url = basename(Storage::disk('public')->putFileAs('estampas\\', $validatedData['imagem_url'], $estampa->id . "_" . uniqid() . '.png'));
                }
            }
            $estampa->informacao_extra = [
                'cor_codigo' => $validatedData['cor_codigo'],
                'inputOpacidade' => $validatedData['inputOpacidade'],
                'inputPosicao' => $validatedData['inputPosicao'],
                'inputRotacao' => $validatedData['inputRotacao']
            ];

            $estampa->save();

            return redirect()->route('estampas.edit', $estampa)
                ->withInputPosicao($validatedData['inputPosicao'])
                ->withInputRotacao($validatedData['inputRotacao'])
                ->withInputOpacidade($validatedData['inputOpacidade'])
                ->withCor($cor)
                ->withPrecos($precos)
                ->withCores($listaCores)
                ->withEstampa($estampa)
                ->withCategorias($listaCategorias)
                ->with('alert-msg', 'Estampa foi alterada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - EstampasController',
                'message'   =>   $th->getMessage()
            );

            Mail::to(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MAGICTSHIRTS.com'))->send(new SendMail($data));
            return redirect()->route('estampas.edit', $estampa)
                ->withInputPosicao($request['inputPosicao'])
                ->withInputRotacao($request['inputRotacao'])
                ->withInputOpacidade($request['inputOpacidade'])
                ->withCor($cor)
                ->withPrecos($precos)
                ->withCores($listaCores)
                ->withEstampa($estampa)
                ->withCategorias($listaCategorias)
                ->with('alert-msg', 'Estampa NÃO foi alterada com sucesso!')
                ->with('alert-type', 'danger');
        }
    }

    public function store(EstampaPost $request)
    {
        try {
            $validatedData = $request->validated();
            $estampa = new Estampa;
            if (Auth::user()->tipo == 'C') {
                $estampa->cliente_id =  Auth::user()->id;
                if ($request->hasFile('imagem_url')) {
                    $estampa->imagem_url = basename(Storage::disk('local')->putFileAs('estampas_privadas\\', $validatedData['imagem_url'], $estampa->id . "_" . uniqid() . '.png'));
                }
            } else {
                if ($request->hasFile('imagem_url')) {
                    $estampa->imagem_url = basename(Storage::disk('public')->putFileAs('estampas\\', $validatedData['imagem_url'], $estampa->id . "_" . uniqid() . '.png'));
                }
            }
            $estampa->categoria_id = $validatedData['categoria_id'];
            $estampa->nome = $validatedData['nome'];
            $estampa->descricao = $validatedData['descricao'];

            if ($request->has('informacao_extra')) {
                $estampa->informacao_extra = $validatedData['informacao_extra'];
            }
            $estampa->save();
            if (Auth::user()->tipo == 'C') {

                return redirect()->route('estampasUser', Auth::user())
                    ->with('alert-msg', 'Estampa foi criada com sucesso!')
                    ->with('alert-type', 'success');
            } else {
                return redirect()->route('estampas')
                    ->with('alert-msg', 'Estampa foi criada com sucesso!')
                    ->with('alert-type', 'success');
            }

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
                ->with('alert-type', 'danger');
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
            if ($estampa->cliente_id == null) {
                $watermark = Image::make(public_path('storage\estampas\\').$estampa->imagem_url);
            } else {
                $watermark = Image::make(storage_path('app\estampas_privadas\\'.$estampa->imagem_url));
            }
            $watermark->height() > $img->width() ? $width=null : $height=null;
            $watermark->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $watermark->resizeCanvas($watermark->width(), $watermark->height(), 'center', false, 'rgba(0, 0, 0, 0)');

            $watermark->rotate($rotacao);
            $watermark->opacity($opacidade);
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
