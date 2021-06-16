<?php

namespace App\Exports;

use App\Models\Cliente;
use App\Models\Estampa;
use App\Models\Tshirt;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpParser\Node\Expr\AssignOp\Concat;

class StatisticsExport implements FromCollection,WithHeadings
{

    protected $parameter;

    function __construct($parameter) {
        $this->parameter = $parameter;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        switch ($this->parameter) {
            case 'Roda das cores':
                $qry = DB::table("tshirts")
                    ->select(DB::raw('CONCAT("#",upper(cor_codigo)), count(id) as `count`'))
                    ->groupby('cor_codigo')->orderBy('count', 'desc');
                return $qry->get();
                break;
            case 'Encomendas por ano':
                $qry = DB::table("encomendas")
                    ->select(DB::raw("DATE_FORMAT(created_at, '%Y') new_date"), DB::raw('count(id) as `data`'))
                    ->groupby('new_date');
                return $qry->get();
                break;
            case 'Quantidade de encomendas por mês':
                $qry = DB::table("encomendas")
                    ->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"))
                    ->groupby('new_date');
                return $qry->get();
                break;
            case 'Estampas mais vendidas nos ultimos 3 meses':
                $join = DB::table('tshirts')->select(DB::raw('tshirts.estampa_id, COUNT(*) as countTOP'))->groupBy('tshirts.estampa_id')->orderBy(DB::raw('COUNT(*)'), 'desc')->join('encomendas', 'encomendas.id', 'tshirts.encomenda_id')->whereRaw(DB::raw('encomendas.created_at >= NOW() - INTERVAL 3 MONTH'))->take(50);
                $estampasTOP = Estampa::whereNull('estampas.cliente_id')->select('estampas.nome', 'countTOP')
                    ->joinSub($join, 'tshirt', 'tshirt.estampa_id', 'estampas.id');
                return $estampasTOP->get();
                break;
            case 'Clientes que mais compraram nos ultimos 3 meses':
                $join = Tshirt::select(DB::raw('COUNT(*) as countTOP, encomendas.cliente_id as cliente_id'))->groupBy(DB::raw('encomendas.cliente_id'))->join('encomendas', 'encomendas.id', '=', 'tshirts.encomenda_id');
                $join = DB::table('encomendas')->select(DB::raw('encomendas.cliente_id, COUNT(*) as countTOPEncomendas, tshirts.countTOP as countTOPTshirts'))->groupBy('encomendas.cliente_id')->whereRaw(DB::raw('encomendas.created_at >= NOW() - INTERVAL 3 MONTH'))
                    ->joinSub($join, 'tshirts', 'tshirts.cliente_id', 'encomendas.cliente_id')
                    ->take(50);

                $clientesTOP = Cliente::select('users.name', 'countTOPEncomendas', 'countTOPTshirts')
                    ->orderBy(DB::raw('countTOPTshirts'), 'desc')
                    ->join('users', 'users.id', 'clientes.id')
                    ->joinSub($join, 'encomendas', 'encomendas.cliente_id', 'clientes.id');
                return $clientesTOP->get();
            case 'Estatisticas simples':
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
                return new Collection([
                    [$totalClientesAtivos, $percentagemClientesAtivos, '', $mediaTshirtsPorCliente, '', $valorDeVendasSemanal, $percentagemValorDeVendasSemanal, '', $valorTopDeVendasSemanal, $percentagemValorTopDeVendasSemanal],
                ]);
                break;
            /*case 'Todas':
                //Roda das cores
                //$collect1H = new Collection(['Roda das Cores'],['Código', 'Quantidade']);
                $collect1 = collect(DB::table("tshirts")
                    ->select(DB::raw('cor_codigo, count(id) as `count`'))
                    ->groupby('cor_codigo')->orderBy('count', 'desc')
                    ->get());

                //Encomendas por ano
                //$collect2H = new Collection(['Data (Ano)', 'Quantidade']);
                $collect2 = collect(DB::table("encomendas")
                    ->select(DB::raw("DATE_FORMAT(created_at, '%Y') new_date"), DB::raw('count(id) as `data`'))
                    ->groupby('new_date')
                    ->get());

                //Quantidade de encomendas por mês
                $collect3 = collect(DB::table("encomendas")
                    ->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"))
                    ->groupby('new_date')->get());

                return DB::raw('select "@x" as table_name');
                dd($collect1->concat($collect2));
                return $qry->get();
                break;*/
        }
        return null;
    }

    public function headings() : array
    {
        switch ($this->parameter) {
            case 'Roda das cores':
                return ['Código', 'Quantidade'];
                break;
            case 'Encomendas por ano':
                return ['Data (Ano)', 'Quantidade'];
                break;
            case 'Quantidade de encomendas por mês':
                return ['Data (Mês-Ano)', 'Quantidade'];
                break;
            case 'Estampas mais vendidas nos ultimos 3 meses':
                return ['Estampa', 'Quantidade'];
                break;
            case 'Clientes que mais compraram nos ultimos 3 meses':
                return ['Cliente', 'Quantidade Encomendas', 'Quantidade Tshirts'];
            case 'Estatisticas simples':
                return ['totalClientesAtivos', 'percentagemClientesAtivosRelativos1MesAtras', '', 'mediaTshirtsPorCliente', '', 'valorDeVendasSemanal', 'percentagemValorDeVendasSemanalRelativosA1SemanaAtras', '', 'valorTopDeVendasSemanal', 'percentagemValorTopDeVendasSemanalRelativosA1SemanaAtras'];
        }
        return [];
    }
}
