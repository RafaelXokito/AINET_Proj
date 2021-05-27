<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstampaPost;
use App\Mail\SendMail;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Estampa;
use App\Models\User;
use App\Policies\EstampaPolicy;
use Illuminate\Support\Facades\Mail;

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

    public function store(EstampaPost $estampa)
    {
        try {
            $validatedData = $estampa->validate();
            $estampa = Estampa::findOrFail($estampa->id);

        } catch (\Throwable $th) {
            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - PrecoController',
                'message'   =>   $th->getMessage()
            );

            Mail::to(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MAGICTSHIRTS.com'))->send(new SendMail($data));
            return redirect()->route('estampa.create')
                ->withEstampa($estampa)
                ->with('alert-msg', 'Estampa NÃO foi criada com sucesso!')
                ->with('alert-type', 'error');
        }
    }
}
