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
        $apagadoSelected = $request->apagado ?? '';

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
        if ($apagadoSelected == 'deleted') {
            $qry->onlyTrashed();
        } elseif ($apagadoSelected == 'all') {
            $qry->withTrashed();
        }
        $estampas = $qry->paginate(10);

        return view('estampas.index')
            ->withDescricao($descricaoSelected)
            ->withNome($nomeSelected)
            ->withCategoria($categoriaSelected)
            ->withCategorias($listaCategorias)
            ->withEstampas($estampas)
            ->withApagado($apagadoSelected);

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
        $inputZoom = '0';


        if ($estampa->informacao_extra != null) {
            $result = json_decode($estampa->informacao_extra, true);

            $cor = Cor::where('codigo', $result['cor_codigo'])->get()->first();
            $inputPosicao = $result['inputPosicao'];
            $inputRotacao = $result['inputRotacao'];
            $inputOpacidade = $result['inputOpacidade'];
            $inputZoom = $result['inputZoom'];
        }



        if ($estampa->cliente_id == null && Auth::user()->tipo != 'A') {
            return view('estampas.view')
                ->withPrecos($precos)
                ->withInputZoom($inputZoom)
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
                ->withInputZoom($inputZoom)
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
        $validatedData = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nome' => 'required|max:255',
            'descricao' => 'required|string',
            'cor_codigo' => 'exists:cores,codigo',
            'inputOpacidade' => 'min:0|numeric|max:100',
            'inputPosicao' => 'in:top,center,bottom',
            'inputRotacao' => 'min:0|numeric|max:360',
            'inputZoom' => 'min:-3|numeric|max:3',
            'imagem_url' => 'image|max:8192',
        ]);

        try {

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
                'inputZoom' => $validatedData['inputZoom'],
                'inputOpacidade' => $validatedData['inputOpacidade'],
                'inputPosicao' => $validatedData['inputPosicao'],
                'inputRotacao' => $validatedData['inputRotacao']
            ];

            $estampa->save();

            return redirect()->route('estampas.edit', $estampa)
                ->withInputPosicao($validatedData['inputPosicao'])
                ->withInputRotacao($validatedData['inputRotacao'])
                ->withInputOpacidade($validatedData['inputOpacidade'])
                ->withInputZoom($validatedData['inputZoom'])
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
                ->withInputZoom($request['inputZoom'])
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

    public function delete(Estampa $estampa)
    {
        $oldName = $estampa->nome;
        $oldEstampaID = $estampa->id;
        try {
            $estampa->delete();
            Estampa::destroy($oldEstampaID);
            return redirect()->route('estampas')
                ->with('alert-msg', 'Estampa "' . $oldName . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('estampas')
                    ->with('alert-msg', 'Não foi possível apagar o Estampa "' . $oldName . '", porque este user já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('estampas')
                    ->with('alert-msg', 'Não foi possível apagar o Estampa "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function restore($id)
    {
        $estampa = Estampa::withTrashed()->findOrFail($id);
        $this->authorize('restore', $estampa);
        try {
            $estampa->restore();
            return redirect()->route('estampas')
                    ->with('alert-msg', 'Estampa "' . $estampa->nome . '" foi recuperado com sucesso!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('estampas')
                    ->with('alert-msg', 'Não foi possível restaurar a Estampa "' . $estampa->nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }

    public function forceDelete($id)
    {
        $estampa = Estampa::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $estampa);
        $nome = $estampa->nome;
        try {
            $estampa->forceDelete();
            return redirect()->route('estampas')
                    ->with('alert-msg', 'A estampa "' . $nome . '" foi apagada para sempre!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('estampas')
                    ->with('alert-msg', 'Não foi possível apagar a Estampa "' . $nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }

    public function show(Estampa $estampa)
    {
        return response()->file(storage_path('app\estampas_privadas\\'.$estampa->imagem_url));
    }

    public function preview(Estampa $estampa = null, $cor, $posicao, $rotacao, $opacidade, $zoom)
    {
        try {

            // create new Intervention Image
            $img = Image::make(public_path('storage\tshirt_base\\'). $cor.'.jpg');


            $width = 220; // your max width
            $height = 220; // your max heigh

            if ($estampa->cliente_id == null) {
                $watermark = Image::make(public_path('storage\estampas\\').$estampa->imagem_url);
            } else {
                $watermark = Image::make(storage_path('app\estampas_privadas\\'.$estampa->imagem_url));
            }

            if ($zoom >= 0) {
                $width = intval(($width/2) * ($zoom+1));
                $height = intval(($height/2) * ($zoom+1));

                $width > 220 ? $width=220 : false;
                $height > 220 ? $height=220 : false;
            } elseif ($zoom < 0) {
                $width = intval(($width/2) / (($zoom-1)*-1));
                $height = intval(($height/2) / (($zoom-1)*-1));

                $width > 220 ? $width=220 : false;
                $height > 220 ? $height=220 : false;
            }

            $watermark->height() > $img->width() ? $width=null : $height=null;

            $watermark->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            $watermark->resizeCanvas($watermark->width(), $watermark->height(), 'center', false, 'rgba(0, 0, 0, 0)');

            $watermark->rotate($rotacao);
            $watermark->opacity($opacidade);
            //$watermark->resize($watermark->width()*$zoom, $watermark->height()*$zoom);


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
