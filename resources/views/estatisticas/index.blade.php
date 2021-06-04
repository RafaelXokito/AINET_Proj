@extends('layout')
@section('title','Estatísticas' )
@section('content')
<script src="/assets/vendor/chart.js/dist/Chart.min.js"></script>
<script src="/assets/vendor/chart.js/dist/Chart.extension.js"></script>

<!--* Card init *-->
<div class="card">
    <!-- Card header -->
    <div class="card-header">
       <!-- Title -->
       <h5 class="h3 mb-0">Bars chart</h5>
    </div>
    <!-- Card body -->
    <div class="card-body">
       <div class="chart">
          <!-- Chart wrapper -->
          <canvas id="chart-bars" class="chart-canvas"></canvas>
       </div>
    </div>
 </div>
@endsection
