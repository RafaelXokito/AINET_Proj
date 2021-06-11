<?php

namespace App\Http\Controllers;

use App\Charts\UserChart;


class PageController extends Controller
{
    public function index()
    {
        return view('layout');
    }

    public function indexEstatisticas()
    {
        $usersChart = new UserChart;
        $usersChart->labels(['Jan', 'Feb', 'Mar']);
        $usersChart->dataset('Users by trimester', 'line', [10, 25, 13]);
        return view('estatisticas.index', [ 'usersChart' => $usersChart ]);
    }
}
