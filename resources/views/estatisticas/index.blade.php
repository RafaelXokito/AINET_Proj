@extends('layout')
@section('title','Estatísticas' )
@section('content')
<link href="{{asset('css/estatisticas.css')}}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<div class="container">
    <input id="url" data-url='{{url('/')}}' hidden>
    <br><br>
    <div class="card-header text-center mt-5">
        <h3>Roda das cores</h3>
        <small>Cores mais usadas</small>
    </div>
    <div id="chartCircle" style="height: 300px;"></div>
    <br><br>
    <div class="card-header text-center mt-5">
        <h3>Encomendas por ano</h3>
    </div>
    <div id="chartBarCurve" style="height: 300px;"></div>
    <div class="card-header text-center mt-5">
        <h3>Quantidade de encomendas por mês</h3>
    </div>
    <div id="chartBar" style="height: 300px;"></div>
    <div>
        <div class="card-header text-center mt-5">
            <h3>Estampas mais vendidas nos ultimos 3 meses</h3>
        </div>
        <div class="card-deck row">
            @foreach ($estampasTOP as $estampa)
            <div class="col-sm-4 mt-2 px-0">
                <div class="card" style="background-color: #f8f8f8">
                    @php
                        $informacoesextra = json_decode($estampa->informacao_extra, true);
                    @endphp
                    <div class="card-header text-center"><span class="text-danger"><strong>{{$estampa->countTOP}}</strong></span> Vendidos</div>
                    <div>
                        <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" class="card-img-top rounded mx-auto d-block mt-2" style="width: 100px" alt="preview da estampa">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{$estampa->nome}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-3">
            {!! $estampasTOP->withQueryString()->links("pagination::bootstrap-4") !!}
        </div>
    </div>

    <div>
        <div class="card-header text-center mt-5">
            <h3>Clientes que mais compraram nos ultimos 3 meses</h3>
        </div>
        <div class="card-deck row">
            @foreach ($clientesTOP as $cliente)
            <div class="col-sm-4 mt-2 px-0">
                <div class="card" style="background-color: #f8f8f8">
                    <div class="card-header text-center"><span class="text-danger"><strong>{{$cliente->countTOPEncomendas}}</strong></span> Encomendas e <span class="text-danger"><strong>{{$cliente->countTOPTshirts}}</strong></span> Tshirts</div>
                    <img src="{{$cliente->user->foto_url ? asset('storage/fotos/' . $cliente->user->foto_url) : asset('img/default_img.png') }}" class="card-img-top rounded mx-auto d-block mt-2" style="width: 100px" alt="preview da estampa">
                    <div class="card-body">
                        <h5 class="card-title">{{$cliente->user->name}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-3">
            {!! $clientesTOP->withQueryString()->links("pagination::bootstrap-4") !!}
        </div>
    </div>
    <div class="card-header text-center mt-5">
        <h3>Estatisticas simples</h3>
    </div>
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
                                    {{floor($mediaTshirtsPorCliente)}}
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
                                    {{$valorTopDeVendasSemanal}}€
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
    var url = document.getElementById('url');
    const chartBar = new Chartisan({
    el: '#chartBar',
    url: url.getAttribute('data-url')+'/estatisticasEncomendasPorMes',
    hooks: new ChartisanHooks()
        .beginAtZero()
        .colors(),
    })
    const chartCircle     = new Chartisan({
    el: '#chartCircle',
    url: url.getAttribute('data-url')+'/estatisticasCoresMaisUsadas',
    hooks: new ChartisanHooks()
        .datasets('doughnut')
        .pieColors({!! $cores !!}),
    })

    const chart = new Chartisan({
    el: '#chartBarCurve',
    url: url.getAttribute('data-url')+'/estatisticasEncomendasPorAno',
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
