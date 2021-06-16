@extends('layout')

@section('content')

<div>
    <div class="card-header text-center mt-5 border-danger">
        <h3><i class="fad fa-fw fa-tags"></i> Descontos Mágicos</h3>
    </div>
    <div class="card mt-2 px-0">
        <div class="card-body">
            <p class="card-text text-center">Na compra de {{$precos->quantidade_desconto}} ou mais T-shirts ao carrinho, será aplicado um desconto em cada uma das T-shirts.</p>
            <p class="card-text text-center">Estampas publicas sem desconto {{number_format($precos->preco_un_catalogo,2)}} com desconto <span class="text-danger">{{number_format($precos->preco_un_catalogo_desconto,2)}}</span>€.</p>
            <p class="card-text text-center">Estampas próprias sem desconto {{number_format($precos->preco_un_proprio,2)}} com desconto <span class="text-danger">{{number_format($precos->preco_un_proprio_desconto,2)}}</span>€.</p>
            <div class="text-center">
                <a href="{{route('estampas')}}" class="btn btn-outline-dark">Estampas</a>
            </div>
        </div>
    </div>
<div>
    <div class="card-header text-center mt-5 border-danger">
        <h3><i class="fal fa-staff"></i> Estampas mais vendidas</h3>
    </div>
    <div class="card-deck row">
        @foreach ($estampasTOP as $estampa)
        <div class="col-sm-4 mt-2 px-0" onmouseover="onMouseOverToULModal('UL{{$estampa->id}}')">
            <div class="card" style="background-color: #f8f8f8">
                @php
                    $informacoesextra = json_decode($estampa->informacao_extra, true);
                @endphp
                <div class="card-header text-center"><span class="text-danger"><strong>{{$estampa->countTOP}}</strong></span> Vendidos</div>
                <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" class="card-img-top" alt="preview da estampa">
                <div class="card-body">
                    <h5 class="card-title">{{$estampa->nome}}</h5>
                    <p class="card-text">{{$estampa->descricao}}</p>
                    @php
                        $data = now()->diffInMinutes($estampa->created_at);
                    @endphp
                    @if ($estampa->cliente_id == null)
                    @can('edit', $estampa)
                        <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver/Editar Estampa</a>
                    @endcan
                    @cannot('edit', $estampa)
                        <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @endcan
                    @else
                        <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @endif
                    <p class="card-text"><small class="text-muted">{{$data > 60 ? ( $data/60 > 24 ? 'Criada à '.floor( (($data/60)/24) ).' dias atrás' : 'Criada à '.floor( ($data/60) ).' horas atrás' ) : 'Criada à '.floor( $data ).' minutos atrás'}}</small></p>
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
    <div class="card-header text-center mt-5 border-danger">
        <h3><i class="fal fa-sparkles"></i> Ultimos Lançamentos</h3>
    </div>
    <div class="card-deck row">
        @foreach ($estampasUL as $estampa)
        <div class="col-sm-4 mt-2 px-0" onmouseover="onMouseOverToULModal('UL{{$estampa->id}}')">
            <div class="card" style="background-color: #f8f8f8">
                @php
                    $informacoesextra = json_decode($estampa->informacao_extra, true);
                @endphp
                <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" class="card-img-top" alt="preview da estampa">
                <div class="card-body">
                    <h5 class="card-title">{{$estampa->nome}}</h5>
                    <p class="card-text">{{$estampa->descricao}}</p>
                    @php
                        $data = now()->diffInMinutes($estampa->created_at);
                    @endphp
                    @if ($estampa->cliente_id == null)
                    @can('edit', $estampa)
                        <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver/Editar Estampa</a>
                    @endcan
                    @cannot('edit', $estampa)
                        <a href="{{route('estampas.view', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @endcan
                    @else
                        <a href="{{route('estampas.edit', ['estampa' => $estampa])}}" class="btn btn-primary">Ver Estampa na t-shirt</a>
                    @endif
                    <p class="card-text"><small class="text-muted">{{$data > 60 ? ( $data/60 > 24 ? 'Criada à '.floor( (($data/60)/24) ).' dias atrás' : 'Criada à '.floor( ($data/60) ).' horas atrás' ) : 'Criada à '.floor( $data ).' minutos atrás'}}</small></p>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
