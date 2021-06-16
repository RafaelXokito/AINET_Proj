<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\Cliente;
use App\Models\Cor;
use App\Models\Encomenda;
use App\Models\Estampa;
use App\Models\Tshirt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;



class PageController extends Controller
{
    public function index()
    {
        return view('layout');
    }

    public function indexEstatisticas()
    {
        $cores = DB::table("cores")->select(DB::raw("CONCAT('#',codigo) as codigo"))->pluck('codigo');

        $totalClientesAtivos = DB::table("users")->select(DB::raw('count(*) as count'))->where('bloqueado', '=', '0')->first()->count;
        $newDateTime = Carbon::now()->subMonths(1);
        $totalClientesOldAtivos = DB::table("users")->select(DB::raw('count(*) as count'))->where('bloqueado', '=', '0')->where('created_at', '<=', $newDateTime)->first()->count;
        $percentagemClientesAtivos = $totalClientesAtivos > $totalClientesOldAtivos ? ($totalClientesAtivos / $totalClientesOldAtivos)*100 : '-'.(($totalClientesOldAtivos / $totalClientesAtivos)*100);

        $mediaTshirtsPorCliente = DB::table( DB::table('tshirts')->select(DB::raw('COUNT(encomendas.cliente_id) as count'))
            ->groupBy('encomendas.cliente_id')
            ->join('encomendas', 'encomendas.id', '=', 'tshirts.encomenda_id'))->select(DB::raw('AVG(count) as avg'))->first()->avg;

        $valorDeVendasSemanal = DB::table('encomendas')->select(DB::raw('SUM(preco_total) AS total'))->where('estado', '=', 'fechada')->whereRaw(DB::raw('data >= NOW() - INTERVAL 7 DAY'))->first()->total ?? 0;
        $valorDeVendasOldSemanal = DB::table('encomendas')->select(DB::raw('SUM(preco_total) as total'))->where('estado', '=', 'fechada')->whereRaw(DB::raw('data <= NOW() - INTERVAL 7 DAY'))->whereRaw(DB::raw('data >= NOW() - INTERVAL 14 DAY'))->first()->total ?? 0;
        $percentagemValorDeVendasSemanal = $valorDeVendasSemanal > $valorDeVendasOldSemanal ? ($valorDeVendasSemanal / $valorDeVendasOldSemanal)*100 : ($valorDeVendasSemanal > 0 ? ('-'.(($valorDeVendasOldSemanal / $valorDeVendasSemanal)*100)) : 0);

        $valorTopDeVendasSemanal = DB::table('encomendas')->select(DB::raw('MAX(preco_total) AS total'))->where('estado', '=', 'fechada')->whereRaw(DB::raw('data >= NOW() - INTERVAL 7 DAY'))->first()->total ?? 0;
        $valorTopDeVendasOldSemanal = DB::table('encomendas')->select(DB::raw('MAX(preco_total) as total'))->where('estado', '=', 'fechada')->whereRaw(DB::raw('data <= NOW() - INTERVAL 7 DAY'))->whereRaw(DB::raw('data >= NOW() - INTERVAL 14 DAY'))->first()->total ?? 0;
        $percentagemValorTopDeVendasSemanal = $valorTopDeVendasSemanal > $valorTopDeVendasOldSemanal ? ($valorTopDeVendasSemanal / $valorTopDeVendasOldSemanal)*100 : ($valorTopDeVendasSemanal > 0 ? ('-'.(($valorTopDeVendasOldSemanal / $valorTopDeVendasSemanal)*100)) : 0);

        $join = DB::table('tshirts')->select(DB::raw('tshirts.estampa_id, COUNT(*) as countTOP'))->groupBy('tshirts.estampa_id')->orderBy(DB::raw('COUNT(*)'), 'desc')->join('encomendas', 'encomendas.id', 'tshirts.encomenda_id')->whereRaw(DB::raw('encomendas.created_at >= NOW() - INTERVAL 3 MONTH'))->take(50);
        $estampasTOP = Estampa::whereNull('estampas.cliente_id')->select('estampas.*', 'countTOP')
            ->joinSub($join, 'tshirt', 'tshirt.estampa_id', 'estampas.id');

        $join = Tshirt::select(DB::raw('COUNT(*) as countTOP, encomendas.cliente_id as cliente_id'))->groupBy(DB::raw('encomendas.cliente_id'))->join('encomendas', 'encomendas.id', '=', 'tshirts.encomenda_id');
        $join = DB::table('encomendas')->select(DB::raw('encomendas.cliente_id, COUNT(*) as countTOPEncomendas, tshirts.countTOP as countTOPTshirts'))->groupBy('encomendas.cliente_id')->whereRaw(DB::raw('encomendas.created_at >= NOW() - INTERVAL 3 MONTH'))
            ->joinSub($join, 'tshirts', 'tshirts.cliente_id', 'encomendas.cliente_id')
            ->take(50);

        $clientesTOP = Cliente::select('clientes.*', 'countTOPEncomendas', 'countTOPTshirts')
            ->orderBy(DB::raw('countTOPTshirts'), 'desc')
            ->joinSub($join, 'encomendas', 'encomendas.cliente_id', 'clientes.id');

        return view('estatisticas.index')
            ->withTotalClientesAtivos($totalClientesAtivos)
            ->withPercentagemClientesAtivos(number_format(($percentagemClientesAtivos), 2))
            ->withMediaTshirtsPorCliente(number_format(($mediaTshirtsPorCliente), 2))
            ->withValorDeVendasSemanal($valorDeVendasSemanal)
            ->withPercentagemValorDeVendasSemanal(number_format($percentagemValorDeVendasSemanal, 2))
            ->withValorTopDeVendasSemanal($valorTopDeVendasSemanal)
            ->withPercentagemValorTopDeVendasSemanal(number_format($percentagemValorTopDeVendasSemanal, 2))
            ->withCores($cores)
            ->withEstampasTOP($estampasTOP->paginate(6))
            ->withClientesTOP($clientesTOP->paginate(6));
    }

    public function indexEstatisticasEncomendasPorMes()
    {
        $dbRate = DB::table("encomendas")
            ->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"))
            ->groupby('new_date')
            ->pluck('data', 'new_date');
        $data = '{
            "chart": { "labels": '.json_encode(array_keys($dbRate->toArray())).' },
            "datasets": [
                        { "name": "Quantidade de encomendas", "values": '.json_encode(array_values($dbRate->toArray())).' }]}';

        //$data['chart']['labels'] = json_encode(["First", "Second", "Third"]);
        return response()
            ->json(json_decode($data));
    }

    public function indexEstatisticasEncomendasPorAno()
    {
        $dbRate = DB::table("encomendas")
            ->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%Y') new_date"))
            ->groupby('new_date')
            ->pluck('data', 'new_date');
        $data = '{
            "chart": { "labels": '.json_encode(array_keys($dbRate->toArray())).' },
            "datasets": [
                        { "name": "Quantidade de encomendas", "values": '.json_encode(array_values($dbRate->toArray())).' }]}';

        //$data['chart']['labels'] = json_encode(["First", "Second", "Third"]);
        return response()
            ->json(json_decode($data));
    }

    public function indexEstatisticasCoresMaisUsadas()
    {
        $dbRate = DB::table("tshirts")
            ->select(DB::raw('count(id) as `count`'), 'cor_codigo')
            ->groupby('cor_codigo')
            ->pluck('count', 'cor_codigo');
        $data = '{
            "chart": { "labels": '.json_encode(array_keys($dbRate->toArray())).' },
            "datasets": [
                        { "name": "Quantidade de encomendas", "values": '.json_encode(array_values($dbRate->toArray())).' }]}';

        //$data['chart']['labels'] = json_encode(["First", "Second", "Third"]);
        return response()
            ->json(json_decode($data));
    }
}
