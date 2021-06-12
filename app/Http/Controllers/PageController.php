<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Models\Cor;
use App\Models\Encomenda;
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

        return view('estatisticas.index')
            ->withTotalClientesAtivos($totalClientesAtivos)
            ->withPercentagemClientesAtivos(number_format(($percentagemClientesAtivos), 2))
            ->withMediaTshirtsPorCliente(number_format(($mediaTshirtsPorCliente), 2))
            ->withValorDeVendasSemanal($valorDeVendasSemanal)
            ->withPercentagemValorDeVendasSemanal(number_format($percentagemValorDeVendasSemanal, 2))
            ->withValorTopDeVendasSemanal($valorTopDeVendasSemanal)
            ->withPercentagemValorTopDeVendasSemanal(number_format($percentagemValorTopDeVendasSemanal, 2))
            ->withCores($cores);
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
