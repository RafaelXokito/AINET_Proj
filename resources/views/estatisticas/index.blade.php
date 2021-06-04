@extends('layout')
@section('title','Estatísticas' )
@section('content')
<html>
  <head>
    <!--totais, médias, máximos, mínimos de vendas em valor ou quantidade
        por mês, por ano,
        organizadas por estampas ou categorias, por cliente, -->

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawBarChart);
      google.charts.setOnLoadCallback(drawPieChart);
      google.charts.setOnLoadCallback(drawAreaChart);
      google.charts.setOnLoadCallback(drawColorChart);
      google.charts.setOnLoadCallback(drawPieChart);


      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawBarChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mushrooms', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('barChart_div'));
        chart.draw(data, {width: 500,
                height: 300,
                title: 'Toppings I Like On My Pizza',
                colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
                });
      }
      //
      function drawPieChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        ['Mushrooms', 3],
        ['Onions', 1],
        ['Olives', 1],
        ['Zucchini', 1],
        ['Pepperoni', 2]
        ]);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('pieChart_div'));
        chart.draw(data, {
                width: 400,
                height: 240,
                title: 'Toppings I Like On My Pizza',
                colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],
                is3D: true
                });
    }
    //vendas por mes ou ano
    function drawAreaChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2013',  1000,      400],
          ['2014',  1170,      460],
          ['2015',  660,       1120],
          ['2016',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('areaChart_div'));
        chart.draw(data, options);
      }
      //Cores de t-shirts mais usadas
      function drawColorChart() {
        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['Assamese', 13], ['Bengali', 83], ['Bodo', 1.4],
          ['Dogri', 2.3], ['Gujarati', 46], ['Hindi', 300],
          ['Kannada', 38], ['Kashmiri', 5.5], ['Konkani', 5],
          ['Maithili', 20], ['Malayalam', 33], ['Manipuri', 1.5],
          ['Marathi', 72], ['Nepali', 2.9], ['Oriya', 33],
          ['Punjabi', 29], ['Sanskrit', 0.01], ['Santhali', 6.5],
          ['Sindhi', 2.5], ['Tamil', 61], ['Telugu', 74], ['Urdu', 52]
        ]);

        var options = {
          title: 'Indian Language Use',
          legend: 'none',
          pieSliceText: 'label',
          slices: {  4: {offset: 0.2},
                    12: {offset: 0.3},
                    14: {offset: 0.4},
                    15: {offset: 0.5},
          },
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('colorPiechart'));
        chart.draw(data, options);
      }
    </script>

  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="barChart_div"> ola</div>
    <div id="pieChart_div"></div>
    <div id="areaChart_div"></div>
    <div id="colorPiechart"></div>
    <div id="pieChart_div"></div>
  </body>
</html>

@endsection
