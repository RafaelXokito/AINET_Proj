<!-- Modal -->
<link href="{{asset('css/detalhesEncomenda.css')}}" rel="stylesheet">

<div class="modal fade" id="alterarEstadoEncomendaModal{{$encomenda->id}}" tabindex="-1" role="dialog" aria-labelledby="alterarEstadoEncomendaModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @cannot('update', App\Models\Encomenda::class)
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fad fa-fw fa-scroll-old"></i> <span id="modalTitle">Visualizar o Estado da Encomenda</span></h5>
                @endcan
                @can('update', App\Models\Encomenda::class)
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fad fa-fw fa-scroll-old"></i> <span id="modalTitle">Alterar Estado da Encomenda</span></h5>
                @endcan
            </div>
            @can('update', App\Models\Encomenda::class)
            <form action="{{route('encomendas.updateEstado', $encomenda)}}" id="formUpdate{{$encomenda->id}}" method="POST">@csrf @method('PUT')
            @endcan
                <div class="modal-body">
                    @include('encomendas.partials.detalhes')
                </div>
                <div class="modal-footer">
                    <div class="btn-group d-flex justify-content-center" data-toggle="buttons">
                        @can('isStaff', App\Models\User::class)
                            @if ($encomenda->estado == 'pendente' || Auth::user()->tipo == 'A')
                            <label class="btn btn-outline-warning btn-rounded {{$encomenda->estado == 'pendente' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" value="pendente" class="form-check-input" {{$encomenda->estado == 'pendente' ? 'checked' : ''}} autocomplete="" hidden>Pendente
                            <i class="fad fa-stopwatch"></i>
                            </label>
                            @endif

                            @if ($encomenda->estado == 'pendente' || $encomenda->estado == 'paga' || Auth::user()->tipo == 'A')
                            <label class="btn btn-outline-primary btn-rounded {{$encomenda->estado == 'paga' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" value="paga" class="form-check-input" {{$encomenda->estado == 'paga' ? 'checked' : ''}} autocomplete="" hidden>Paga
                            <i class="fad fa-euro-sign"></i>
                            </label>
                            @endif

                            @if ($encomenda->estado == 'paga' || Auth::user()->tipo == 'A')
                            <label class="btn btn-outline-success btn-rounded {{$encomenda->estado == 'fechado' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" value="fechado" class="form-check-input" {{$encomenda->estado == 'fechado' ? 'checked' : ''}} autocomplete="" hidden>Fechado
                            <i class="fad fa-box-full"></i>
                            </label>
                            @endif
                        @endcan
                        @can('isAdmin', App\Models\User::class)
                            <label class="btn btn-outline-danger btn-rounded {{$encomenda->estado == 'anulado' ? 'active' : ''}} form-check-label">
                            <input type="radio" name="estado" value="anulado" class="form-check-input" {{$encomenda->estado == 'anulado' ? 'checked' : ''}} autocomplete="" hidden>Anulado
                            <i class="fad fa-lock"></i>
                            </label>
                        @endcan

                    </div>

                    <div class="container">
                    <div class="row line">
                        <div class="col-xs-4 stepText1">Step 1</div>
                        <div class="col-xs-4 stepText2">Step 2</div>
                        <div class="col-xs-4 stepText3">Step 3</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4"><div class="step step1 activeStep" style="margin-left: 0%"></div></div>
                        <div class="col-xs-4"><div class="step step2" style="margin-left: 50%"></div></div>
                        <div class="col-xs-4"><div class="step step3" style="margin-left: 100%"></div></div>
                    </div>
                    </div>



                </div>
            @can('update', App\Models\Encomenda::class)
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="modalCriarBtn">Alterar</button>
                </div>
            </form>
            @endcan
        </div>
    </div>
</div>
