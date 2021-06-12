@extends('layout')
@section('title','Estatísticas' )
@section('content')
<link href="{{asset('css/estatisticas.css')}}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<div class="container">
    <div id="chartBar" style="height: 300px;"></div>
    <br><br>
    <div id="chartCircle" style="height: 300px;"></div>
    <br><br>
    <div id="chartBarCurve" style="height: 300px;"></div>



    <div class="col-md-12 mt-5">
        <div class="row">
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Média de tshirts compradas por cliente</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-6">
                                <h2 class="d-flex align-items-center mb-0">
                                    {{$mediaTshirtsPorCliente}}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Total Clientes Ativos</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-6">
                                <h2 class="d-flex align-items-center mb-0">
                                    {{$totalClientesAtivos}}
                                </h2>
                            </div>
                            <div class="col text-right">
                                @if ($percentagemClientesAtivos > 0)
                                    <span>{{$percentagemClientesAtivos}}% <i class="fa fa-arrow-up"></i></span>
                                @else
                                    <span>{{$percentagemClientesAtivos}}% <i class="fa fa-arrow-down"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Maior compra dos ultimos 7 dias</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-6">
                                <h2 class="d-flex align-items-center mb-0">
                                    {{$valorTopDeVendasSemanal}}
                                </h2>
                            </div>
                            <div class="col text-right">
                                @if ($percentagemValorTopDeVendasSemanal > 0)
                                    <span>{{$percentagemValorTopDeVendasSemanal}}% <i class="fa fa-arrow-up"></i></span>
                                @else
                                    <span>{{$percentagemValorTopDeVendasSemanal}}% <i class="fa fa-arrow-down"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Valor de vendas dos ultimos 7 dias</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    {{$valorDeVendasSemanal}}€
                                </h2>
                            </div>
                            <div class="col text-right">
                                @if ($percentagemValorDeVendasSemanal > 0)
                                    <span>{{$percentagemValorDeVendasSemanal}}% <i class="fa fa-arrow-up"></i></span>
                                @else
                                    <span>{{$percentagemValorDeVendasSemanal}}% <i class="fa fa-arrow-down"></i></span>
                                @endif
                            </div>
                        </div>
                        <!--<div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
<!-- Your application script -->
<script>
    const chartBar = new Chartisan({
    el: '#chartBar',
    url: 'http://ainet_proj.test/estatisticasEncomendasPorMes',
    hooks: new ChartisanHooks()
        .beginAtZero()
        .colors(),
    })
    const chartCircle     = new Chartisan({
    el: '#chartCircle',
    url: 'http://ainet_proj.test/estatisticasCoresMaisUsadas',
    hooks: new ChartisanHooks()
        .datasets('doughnut')
        .pieColors({!! $cores !!}),
    })

    const chart = new Chartisan({
    el: '#chartBarCurve',
    url: 'http://ainet_proj.test/estatisticasEncomendasPorAno',
    hooks: new ChartisanHooks()
        .beginAtZero()
        .colors()
        .borderColors()
        .datasets([{ type: 'line', fill: false }, 'bar']),
    })
</script>
<!--totais, médias, máximos, mínimos de vendas em valor ou quantidade
    por mês, por ano,
    organizadas por estampas ou categorias, por cliente, -->

@endsection
