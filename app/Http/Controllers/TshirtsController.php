<?php

namespace App\Http\Controllers;

use App\Models\Cor;
use App\Models\Encomenda;
use App\Models\Estampa;
use App\Models\Preco;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TshirtsController extends Controller
{
    //Carrinho de Compras
    public function carrinho(Request $request)
    {
        $informacoes_extra = [];
        foreach ($request->session()->get('carrinho') ?? [] as $key => $value) {
            if ($value['estampa']->informacao_extra == null) {
                continue;
            }
            $json = json_decode($value['estampa']->informacao_extra);
            $informacoes_extra[$key]['inputZoom'] = $json->inputZoom;
            $informacoes_extra[$key]['cor_codigo'] = $json->cor_codigo;
            $informacoes_extra[$key]['inputPosicao'] = $json->inputPosicao;
            $informacoes_extra[$key]['inputRotacao'] = $json->inputRotacao;
            $informacoes_extra[$key]['inputOpacidade'] = $json->inputOpacidade;
        }

        return view('carrinho.index')
            ->withInformacoesextra($informacoes_extra)
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

        $result = json_decode($estampa->informacao_extra);
        if ($result != null) { //Há tshirts que não têm info extra então para prevenir
            $key = $estampa->id . '.' . $validatedData['tamanho'] . '.' . $validatedData['cor_codigo'] . '.' . $result->inputZoom . '.' . $result->inputPosicao . '.' . $result->inputRotacao . '.' . $result->inputOpacidade;
        } else {
            $key = $estampa->id . '.' . $validatedData['tamanho'] . '.' . $validatedData['cor_codigo'];
        }
        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$key]['quantidade'] ?? 0) + $validatedData['quantidade'];

        if ($previusRoute == 'estampas.edit') {
            if ($qtd >= $precos->quantidade_desconto) {
                $preco_un = $precos->preco_un_proprio_desconto;
            } else {
                $preco_un = $precos->preco_un_proprio;
            }
            $preco_subotal = $preco_un * $qtd;
        }

        if ($previusRoute == 'estampas.view') {
            if ($qtd >= $precos->quantidade_desconto) {
                 $preco_un = $precos->preco_un_catalogo_desconto;
            } else {
                 $preco_un = $precos->preco_un_catalogo;
            }
            $preco_subotal = $preco_un * $qtd;
        }

        $carrinho[$key] = [
            'id' => $key,
            'estampa' => $estampa,
            'quantidade' => $qtd,
            'tamanho' => $validatedData['tamanho'],
            'cor_codigo' => $validatedData['cor_codigo'],
            'preco_un' => $preco_un,
            'subtotal' => $preco_subotal,
        ];
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', 'Foi adicionada uma tshirt ao carrinho! Quantidade = ' .  $validatedData['quantidade'])
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
                'estampa' => $tshirt->estampa,
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

    public function destroy_tshirt(Request $request, $key)
    {
        $carrinho = $request->session()->get('carrinho', []);
        if (array_key_exists($key, $carrinho)) {
            unset($carrinho[$key]);
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
        try {
            dd($request->session()->get('carrinho'));

            DB::beginTransaction();

            $encomenda = new Encomenda;
            $encomenda->estado = 'pendente';
            $encomenda->cliente_id = Auth::user()->id;
            $encomenda->data = now();
            //dados do pagamento TODO
            $encomenda->save();

            foreach ($request->session()->get('carrinho') as $key => $value) {
                dd($key, $value);
                $tshirt = new Tshirt;
                $tshirt->encomenda_id = $encomenda->id;
                $tshirt->estampa_id = $value->estampa_id;
                $tshirt->cor_codigo = $value->cor_codigo;
                $tshirt->tamanho = $value->tamanho;
                $tshirt->quantidade = $value->quantidade;
                $tshirt->preco_un = $value->preco_un;
                $tshirt->subtotal = $value->subtotal;
                $tshirt->save();
            }

            DB::commit();

            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - Fatura Simplificada',
                'message'   =>   'Fatura <Mensagem>'
            );

            Mail::to(Auth::user()->email)->send(new SendMail($data));

            return back()
                ->with('alert-msg', 'A sua compra foi efetuada! Verifique a fatura no seu Email')
                ->with('alert-type', 'success');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()
                ->with('alert-msg', 'Não conseguimos concluir a sua compra!')
                ->with('alert-type', 'danger');
        }



    }

    public function destroy(Request $request)
    {
        $request->session()->forget('carrinho');
        return back()
            ->with('alert-msg', 'O carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }
}
