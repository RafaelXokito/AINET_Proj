<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\Http\Request;

class TshirtsController extends Controller
{
    //Carrinho de Compras
    public function carrinho(Request $request)
    {
        return view('pages.carrinho')
            ->with('pageTitle', 'Carrinho de compras')
            ->with('carrinho', session('carrinho') ?? []);
    }

    public function store_tshirt(Request $request, Tshirt $tshirt)
    {
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$tshirt->id]['qtd'] ?? 0) + 1;
        $carrinho[$tshirt->id] = [
            'id' => $tshirt->id,
            'qtd' => $qtd,
            'abreviatura' => $tshirt->abreviatura,
            'nome' => $tshirt->nome,
        ];
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', 'Foi adicionada uma inscrição à tshirt "' . $tshirt->nome . '" ao carrinho! Quantidade de inscrições = ' .  $qtd)
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
                'qtd' => $qtd,
                'cor_codigo' => $tshirt->cor_codigo,
                'tamanho' => $tshirt->tamanho,
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
