<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use App\Models\Preco;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class TshirtsController extends Controller
{
    //Carrinho de Compras
    public function carrinho(Request $request)
    {
        return view('pages.carrinho')
            ->with('pageTitle', 'Carrinho de compras')
            ->with('carrinho', session('carrinho') ?? []);
    }

    public function store_tshirt(Request $request, Estampa $estampa)
    {
        $previusRoute = app('router')->getRoutes(url()->previous())->match(app('request')->create(url()->previous()))->getName();

        $validatedData = $request->validate([
            'cor_codigo' => 'required|exists:cores,codigo',
            'tamanho' => 'required|in:XS,S,M,L,XL',
            'quantidade' => 'required|min:0|numeric',
        ]);


        $preco_un = 0;
        $preco_subotal = 0;
        $precos = Preco::get()->first();

        if ($previusRoute == 'estampas.edit') {
            if ($validatedData['quantidade'] >= $precos->quantidade_desconto) {
                $preco_un = $precos->preco_un_proprio_desconto;
            } else {
                $preco_un = $precos->preco_un_proprio;
            }
            $preco_subotal = $preco_un * $validatedData['quantidade'];
        }

        if ($previusRoute == 'estampas.view') {
            if ($validatedData['quantidade'] >= $precos->quantidade_desconto) {
                 $preco_un = $precos->preco_un_catalogo_desconto;
            } else {
                 $preco_un = $precos->preco_un_catalogo;
            }
            $preco_subotal = $preco_un * $validatedData['quantidade'];
        }

        $key = $estampa->id . '#' . $validatedData['tamanho'] . '#' . $validatedData['cor_codigo'];
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$key]['quantidade'] ?? 0);
        $carrinho[$key] = [
            'id' => $key,
            'estampa_id' => $estampa->id,
            'quantidade' => $qtd+$validatedData['quantidade'],
            'tamanho' => $validatedData['tamanho'],
            'cor_codigo' => $validatedData['cor_codigo'],
            'preco_un' => $preco_un,
            'subtotal' => $preco_subotal,
        ];
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', 'Foi adicionada uma tshirt ao carrinho! Quantidade = ' .  $qtd)
            ->with('alert-type', 'success');
    }

    public function update_tshirt(Request $request, Tshirt $tshirt)
    {
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = $carrinho[$tshirt->id]['qtd'] ?? 0;
        $qtd += $request->quantidade;
        if ($request->quantidade < 0) {
            $msg = 'Foram removidas ' . $request->quantidade . ' tshirts! Quantidade atual = ' .  $qtd;
        } elseif ($request->quantidade > 0) {
            $msg = 'Foram adicionadas ' . $request->quantidade . ' tshirts! Quantidade atual = ' .  $qtd;
        }
        if ($qtd <= 0) {
            unset($carrinho[$tshirt->id]);
            $msg = 'Foram removidas todas as tshirts escolhidas.';
        } else {
            $carrinho[$tshirt->id] = [
                'id' => $tshirt->id,
                'estampa_id' => $tshirt->estampa_id,
                'qtd' => $qtd,
                'tamanho' => $tshirt->tamanho,
                'cor_codigo' => $tshirt->cor_codigo,
                'preco_un' => $tshirt->preco_un,
                'subtotal' => $tshirt->subtotal,
            ];
        }
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', $msg)
            ->with('alert-type', 'success');
    }

    public function destroy_tshirt(Request $request, Tshirt $tshirt)
    {
        $carrinho = $request->session()->get('carrinho', []);
        if (array_key_exists($tshirt->id, $carrinho)) {
            unset($carrinho[$tshirt->id]);
            $request->session()->put('carrinho', $carrinho);
            return back()
                ->with('alert-msg', 'Foram removidas as tshirts escolhidas')
                ->with('alert-type', 'success');
        }
        return back()
            ->with('alert-msg', 'A tshirt já não existia no carrinho!')
            ->with('alert-type', 'warning');
    }

    public function store(Request $request)
    {
        dd(
            'Place code to store the shopping cart / transform the cart into a sale',
            $request->session()->get('carrinho')
        );
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('carrinho');
        return back()
            ->with('alert-msg', 'O carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }
}
