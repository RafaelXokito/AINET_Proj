<?php

namespace App\Http\Controllers;

use App\Models\Cor;
use App\Models\Estampa;
use App\Models\Preco;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $join = DB::table('tshirts')->select(DB::raw('tshirts.estampa_id, COUNT(*) as countTOP'))->groupBy('estampa_id')->orderBy(DB::raw('COUNT(*)'), 'desc')->take(9);
        $estampasTOP = Estampa::whereNull('estampas.cliente_id')->select('estampas.*', 'countTOP')
            ->joinSub($join, 'tshirt', 'tshirt.estampa_id', 'estampas.id');
        $estampasUL = Estampa::whereNull('cliente_id')->orderBy('created_at', 'DESC')->take(3)->get();
        $cor = Cor::first();
        $precos = Preco::first();
        return view('home')
            ->withCor($cor)
            ->withPrecos($precos)
            ->withEstampasTOP($estampasTOP->paginate(3))
            ->withEstampasUL($estampasUL);
    }

    public function carrinho()
    {
        return view('carrinho.index');
    }
}
