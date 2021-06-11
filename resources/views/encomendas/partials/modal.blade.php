<!-- Modal -->
<link href="{{asset('css/detalhesEncomenda.css')}}" rel="stylesheet">

<div class="modal fade" id="alterarEstadoEncomendaModal{{$encomenda->id}}" tabindex="-1" role="dialog" aria-labelledby="alterarEstadoEncomendaModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg pb-5" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @cannot('update', App\Models\Encomenda::class)
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fad fa-fw fa-scroll-old"></i> <span id="modalTitle">Visualizar o Estado da Encomenda</span></h5>
                @endcan
                @can('update', App\Models\Encomenda::class)
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fad fa-fw fa-scroll-old"></i> <span id="modalTitle">Alterar Estado da Encomenda</span></h5>
                @endcan
            </div>
                <div class="modal-body" id="detalhes{{$encomenda->id}}">
                    @include('encomendas.partials.detalhes')
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    @can('update', App\Models\Encomenda::class)
                    <div class="btn-group" data-toggle="buttons">
                        @can('isStaff', App\Models\User::class)
                            @if ($encomenda->estado == 'pendente' || Auth::user()->tipo == 'A')
                            <label class="btn btn-outline-warning btn-rounded {{$encomenda->estado == 'pendente' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" form="formUpdate{{$encomenda->id}}" value="pendente" class="form-check-input" {{$encomenda->estado == 'pendente' ? 'checked' : ''}} autocomplete="" hidden>Pendente
                            <i class="fad fa-stopwatch"></i>
                            </label>
                            @endif

                            @if ($encomenda->estado == 'pendente' || $encomenda->estado == 'paga' || Auth::user()->tipo == 'A')
                            <label class="btn btn-outline-primary btn-rounded {{$encomenda->estado == 'paga' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" form="formUpdate{{$encomenda->id}}" value="paga" class="form-check-input" {{$encomenda->estado == 'paga' ? 'checked' : ''}} autocomplete="" hidden>Paga
                            <i class="fad fa-euro-sign"></i>
                            </label>
                            @endif

                            @if ($encomenda->estado == 'paga' || Auth::user()->tipo == 'A')
                            <label class="btn btn-outline-success btn-rounded {{$encomenda->estado == 'fechada' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" form="formUpdate{{$encomenda->id}}" value="fechada" class="form-check-input" {{$encomenda->estado == 'fechada' ? 'checked' : ''}} autocomplete="" hidden>Fechado
                            <i class="fad fa-box-full"></i>
                            </label>
                            @endif
                        @endcan
                        @can('isAdmin', App\Models\User::class)
                            <label class="btn btn-outline-danger btn-rounded {{$encomenda->estado == 'anulada' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" form="formUpdate{{$encomenda->id}}" value="anulada" class="form-check-input" {{$encomenda->estado == 'anulada' ? 'checked' : ''}} autocomplete="" hidden>Anulada
                            <i class="fad fa-lock"></i>
                            </label>
                        @endcan
                    </div>
                    @endcan
                    @cannot('update', App\Models\Encomenda::class)
                    <div class="container d-flex justify-content-center">
                        <div class="row bs-wizard" style="border-bottom:0;">

                            <div class="col-xs-3 bs-wizard-step {{$encomenda->estado == 'pendente' ? 'active' : ''}} {{$encomenda->estado == 'paga' ? 'complete' : ''}} {{$encomenda->estado == 'fechada' ? 'complete' : ''}} {{$encomenda->estado == 'anulada' ? 'complete' : ''}}">
                              <div class="text-center bs-wizard-stepnum"><i class="fad fa-stopwatch"></i></div>
                              <div class="progress"><div class="progress-bar {{$encomenda->estado == 'anulada' ? 'progress-bar-anulada' : ''}}"></div></div>
                              <a href="#" class="bs-wizard-dot {{$encomenda->estado == 'anulada' ? 'bs-wizard-dot-anulado' : ''}}"></a>
                              <div class="bs-wizard-info text-center mx-5">Pendente</div>
                            </div>

                            <div class="col-xs-3 bs-wizard-step {{$encomenda->estado == 'pendente' ? 'disabled' : ''}} {{$encomenda->estado == 'paga' ? 'active' : ''}} {{$encomenda->estado == 'fechada' ? 'complete' : ''}} {{$encomenda->estado == 'anulada' ? 'complete' : ''}}">
                              <div class="text-center bs-wizard-stepnum"><i class="fad fa-euro-sign"></i></div>
                              <div class="progress"><div class="progress-bar {{$encomenda->estado == 'anulada' ? 'progress-bar-anulada' : ''}}"></div></div>
                              <a href="#" class="bs-wizard-dot {{$encomenda->estado == 'anulada' ? 'bs-wizard-dot-anulado' : ''}}"></a>
                              <div class="bs-wizard-info text-center mx-5">Paga</div>
                            </div>
                            <div class="col-xs-3 bs-wizard-step {{$encomenda->estado == 'pendente' ? 'disabled' : ''}} {{$encomenda->estado == 'paga' ? 'disabled' : ''}} {{$encomenda->estado == 'fechada' ? 'active' : ''}} {{$encomenda->estado == 'anulada' ? 'complete' : ''}}">
                              <div class="text-center bs-wizard-stepnum"><i class="fad fa-box-full"></i></div>
                              <div class="progress"><div class="progress-bar {{$encomenda->estado == 'anulada' ? 'progress-bar-anulada' : ''}}"></div></div>
                              <a href="#" class="bs-wizard-dot {{$encomenda->estado == 'anulada' ? 'bs-wizard-dot-anulado' : ''}}"></a>
                              <div class="bs-wizard-info text-center mx-5">Fechada</div>
                            </div>
                            @if ($encomenda->estado == 'anulada')
                            <div class="col-xs-3 bs-wizard-step {{$encomenda->estado == 'pendente' ? 'disabled' : ''}} {{$encomenda->estado == 'paga' ? 'disabled' : ''}} {{$encomenda->estado == 'fechada' ? 'disabled' : ''}} {{$encomenda->estado == 'anulada' ? 'active' : ''}}">
                              <div class="text-center bs-wizard-stepnum"><i class="fad fa-lock"></i></div>
                              <div class="progress"><div class="progress-bar progress-bar-anulada"></div></div>
                              <a href="#" class="bs-wizard-dot bs-wizard-dot-anulado"></a>
                              <div class="bs-wizard-info text-center mx-5">Anulada</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endcannot

                </div>

            @can('update', App\Models\Encomenda::class)
            <form action="{{route('encomendas.updateEstado', $encomenda)}}" id="formUpdate{{$encomenda->id}}" method="POST">
                @csrf
                @method('PUT')
            </form>
            @endcan
            @can('update', App\Models\Encomenda::class)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="formUpdate{{$encomenda->id}}">Alterar</button>
                </div>
            @endcan
        </div>
    </div>
</div>
