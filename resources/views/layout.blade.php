<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{env('APP_NAME','MagicTshirts')}}</title>
    <link rel="icon" href="{{ URL::asset('/img/logo.png') }}" type="image/x-icon"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom icons for this template-->
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-hat-wizard"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{env('APP_NAME','MagicTshirts')}}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item -->
            <li class="nav-item {{Route::currentRouteName()=='estampas'? 'active': ''}}">
                <a class="nav-link" href="{{route('estampas')}}">
                    <i class="fad fa-fw fa-book-spells"></i>
                    <span>Estampas</span>
                </a>
            </li>

            @auth
                @cannot('isStaff', App\Models\User::class)
                    <!-- Nav Item -->
                    <li class="nav-item {{Route::currentRouteName()=='estampasUser'? 'active': ''}}">
                        <a class="nav-link" href="{{route('estampasUser', ['user' => Auth::user()])}}">
                            <i class="fad fa-fw fa-book-user"></i>
                            <span>As minhas Estampas</span>
                        </a>
                    </li>
                @endcannot
            @endauth

            @auth
            <!-- Divider Encomendas -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Nav Item -->
            <li class="nav-item {{Route::currentRouteName()=='encomendas'? 'active': ''}}">
                <a class="nav-link" href="{{route('encomendas')}}">
                    <i class="fad fa-fw fa-scroll-old"></i>
                    <span>Encomendas</span>
                </a>
            </li>
            @endauth

            <!-- Divider STAFF -->
            @can('isStaff', App\Models\User::class)
                <hr class="sidebar-divider d-none d-md-block">

                @can('viewAny', App\Models\User::class)
                <!-- Nav Item -->
                <li class="nav-item {{Route::currentRouteName()=='utilizadores'? 'active': ''}}">
                    <a class="nav-link" href="{{route('utilizadores')}}">
                        <i class="fad fa-fw fa-user-astronaut"></i>
                        <span>Gestão de Utilizadores</span>
                    </a>
                </li>
                @endcan

                <!-- Nav Item -->
                <li class="nav-item {{Route::currentRouteName()=='estatisticas'? 'active': ''}}">
                    <a class="nav-link" href="{{url('estatisticas')}}">
                        <i class="fad fa-fw fa-chart-pie"></i>
                        <span>Estatísticas</span>
                    </a>
                </li>

                @can('edit', App\Models\Preco::class)
                <!-- Nav Item -->
                <li class="nav-item {{Route::currentRouteName()=='precos.edit'? 'active': ''}}">
                    <a class="nav-link" href="{{route('precos.edit')}}">
                        <i class="fad fa-fw fa-tags"></i>
                        <span>Preços Tshirts</span>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\Categoria::class)
                <!-- Nav Item -->
                <li class="nav-item {{Route::currentRouteName()=='categorias'? 'active': ''}}">
                    <a class="nav-link" href="{{route('categorias')}}">
                        <i class="fad fa-boxes"></i>
                        <span>Categorias</span>
                    </a>
                </li>
                @endcan

                @can('viewAny', App\Models\Cor::class)
                <!-- Nav Item -->
                <li class="nav-item {{Route::currentRouteName()=='cores'? 'active': ''}}">
                    <a class="nav-link" href="{{route('cores')}}">
                        <i class="fas fa-palette"></i>
                        <span>Cores</span>
                    </a>
                </li>
                @endcan

            @endcan
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    @guest
                    @if ( (Route::currentRouteName()=='estampas' || Route::currentRouteName()=='estampasUser') )
                        <a class="nav-link" href="{{route('estampas.create')}}">
                            <i class="fal fa-fw fa-wand-magic"></i>
                            <span>Criar estampa</span>
                        </a>
                    @endif
                    @endguest
                    @auth
                    @if ( (Route::currentRouteName()=='estampas' || Route::currentRouteName()=='estampasUser') && Auth::user()->tipo != 'F' )
                        <a class="nav-link" href="{{route('estampas.create')}}">
                            <i class="fal fa-fw fa-wand-magic"></i>
                            <span>Criar estampa</span>
                        </a>
                    @endif
                    @endauth


                    @auth
                        @if (Route::currentRouteName()=='estampas')
                            @cannot('isStaff', App\Models\User::class)
                                <a class="nav-link border-left" href="{{route('estampasUser', ['user' => Auth::user()])}}">
                                    <i class="fad fa-fw fa-book-user"></i>
                                    <span>As minhas Estampas</span>
                                </a>
                            @endcannot
                        @endif
                    @endauth

                    <ul class="navbar-nav ml-auto">
                        @guest
                        <button id="carrinho" class="btn btn-link rounded-circle mr-3">
                            <a href="{{route('carrinho')}}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                        </button>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('login')}}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('register')}}">{{ __('Register') }}</a>
                        </li>
                        @else
                        @can('isClient', App\Models\User::class)
                            <button id="carrinho" class="btn btn-link rounded-circle mr-3">
                                <a href="{{route('carrinho')}}">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                            </button>
                        @endcan

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                                <img class="img-profile rounded-circle" src="{{Auth::user()->foto_url ? asset('storage/fotos/' . Auth::user()->foto_url) : asset('img/default_img.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                @can('edit', Auth::user())
                                <a class="dropdown-item" href="{{route('utilizadores.edit', ['user' => Auth::user()])}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                @endcan

                                @cannot('isStaff', App\Models\User::class)
                                <a class="dropdown-item" href="{{route('encomendas')}}">
                                    <i class="fas fa-clipboard-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Histórico de encomendas
                                </a>
                                <div class="dropdown-divider"></div>
                                @endcannot
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                        @endguest
                    </ul>


                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if (session('alert-msg'))
                        @include('partials.message')
                    @endif
                    @if ($errors->any())
                        @include('partials.errors-message')
                    @endif

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col">
                            @yield('content')
                        </div>

                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Departamento de Engenharia Informática 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary"  href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>


</body>

</html>
