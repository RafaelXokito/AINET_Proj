<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncomendaPost;
use App\Mail\SendMail;
use App\Models\Cor;
use App\Models\Encomenda;
use App\Models\Estampa;
use App\Models\Preco;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        $listaCores = Cor::orderBy('nome')->pluck('nome', 'codigo');
        $precos = Preco::first();
        $cliente = Auth::user() ?? [];

        return view('carrinho.index')
            ->withInformacoesextra($informacoes_extra)
            ->withCores($listaCores)
            ->withUser($cliente)
            ->withPrecos($precos)
            ->with('pageTitle', 'Carrinho de compras')
            ->with('carrinho', session('carrinho') ?? []);
    }

    public function store_tshirt(Request $request, Estampa $estampa)
    {
        if (!Auth::guest()) {
            $this->authorize('isNotStaff', App\Models\User::class);
        }
        $previusRoute = app('router')->getRoutes(url()->previous())->match(app('request')->create(url()->previous()))->getName();

        $validatedData = $request->validate([
            'cor_codigo' => 'required|exists:cores,codigo',
            'tamanho' => 'required|in:XS,S,M,L,XL',
            'quantidade' => 'required|min:0|numeric',
        ]);

        $preco_un = 0;
        $preco_subotal = 0;
        $precos = Preco::get()->first();

        $key = $estampa->id . '.' . $validatedData['tamanho'] . '.' . $validatedData['cor_codigo'];
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
            'key' => $key,
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

    public function update_tshirt(Request $request, $key)
    {
        $carrinho = $request->session()->get('carrinho', []);

        $validatedData = $request->validate([
            'cor_codigo' => 'required|exists:cores,codigo',
            'tamanho' => 'required|in:XS,S,M,L,XL',
            'quantidade' => 'required|min:0|numeric',
        ]);

        $estampa = Estampa::findOrFail($carrinho[$key]['estampa']->id);

        $msg = '';
        $qtd = $carrinho[$key]['quantidade'] - $validatedData['quantidade'];
        if ($qtd > 0) {
            $msg = 'Foram removidas ' . $qtd . ' tshirts! Quantidade atual = ' .  $validatedData['quantidade']. '.';
        } elseif ($qtd < 0) {
            $msg = 'Foram adicionadas ' . $qtd*(-1) . ' tshirts! Quantidade atual = ' .  $validatedData['quantidade'];
        }

        $preco_un = 0;
        $preco_subotal = 0;
        $precos = Preco::get()->first();

        $qtd = $validatedData['quantidade'];
        if ($estampa->cliente_id) {
            if ($qtd >= $precos->quantidade_desconto) {
                $preco_un = $precos->preco_un_proprio_desconto;
            } else {
                $preco_un = $precos->preco_un_proprio;
            }
            $preco_subotal = $preco_un * $qtd;
        } else {
            if ($qtd >= $precos->quantidade_desconto) {
                 $preco_un = $precos->preco_un_catalogo_desconto;
            } else {
                 $preco_un = $precos->preco_un_catalogo;
            }
            $preco_subotal = $preco_un * $qtd;
        }

        if ($validatedData['cor_codigo'] != $carrinho[$key]['cor_codigo']) {
            $msg = $msg.' A cor da tshirt foi alterada.';
        }

        if ($qtd <= 0) {
            unset($carrinho[$key]);
            $msg = 'Foram removidas todas as tshirts escolhidas.';
        } else {
            $Newkey = $estampa->id . '.' . $validatedData['tamanho'] . '.' . $validatedData['cor_codigo'];

            if ($key != $Newkey) {
                if (array_key_exists($key, $carrinho)) {
                    unset($carrinho[$key]);
                    $request->session()->put('carrinho', $carrinho);
                }
                $key = $Newkey;
            }

            $carrinho[$key] = [
                'key' => $key,
                'estampa' => $estampa,
                'quantidade' => $qtd,
                'tamanho' => $validatedData['tamanho'],
                'cor_codigo' => $validatedData['cor_codigo'],
                'preco_un' => $preco_un,
                'subtotal' => $preco_subotal,
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

    public function store(EncomendaPost $request)
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();

            $encomenda = new Encomenda;

            $encomenda->estado = 'pendente';
            $encomenda->cliente_id = Auth::user()->id;
            $encomenda->data = now();
            $encomenda->nif = $validatedData['nif'];
            $encomenda->endereco = $validatedData['endereco'];
            $encomenda->notas = $validatedData['notas'];
            $encomenda->tipo_pagamento = $validatedData['tipo_pagamento'];
            $encomenda->ref_pagamento = $validatedData['ref_pagamento'];


            $preco_total = 0;
            $encomenda->preco_total = $preco_total; //É atualizado depois de percorrermos as tshirts e somarmos. Prevenido com transições pela base de dados

            $encomenda->save();

            $precos = Preco::first();

            foreach ($request->session()->get('carrinho') as $key => $value) {
                $tshirt = new Tshirt;

                $tshirt->encomenda_id = $encomenda->id;
                $tshirt->estampa_id = $value['estampa']->id;
                $tshirt->cor_codigo = $value['cor_codigo'];
                $tshirt->tamanho = $value['tamanho'];
                $tshirt->quantidade = $value['quantidade'];

                if ($tshirt->quantidade >= $precos->quantidade_desconto) {
                    $tshirt->preco_un = ($value['estampa']->cliente_id == null) ? $precos->preco_un_catalogo_desconto : $precos->preco_un_proprio_desconto;
                } else {
                    $tshirt->preco_un = ($value['estampa']->cliente_id == null) ? $precos->preco_un_catalogo : $precos->preco_un_proprio;
                }

                $tshirt->subtotal = $tshirt->preco_un * $value['quantidade'];
                $preco_total += $tshirt->subtotal;

                $tshirt->save();

            }

            $encomenda->preco_total = $preco_total;
            $encomenda->save(); //Atualizamos então o preço total da encomenda.

            $request->session()->forget('carrinho');

            DB::commit();

            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - Fatura Simplificada',
                'message'   =>  'fatura',
                'tshirts'   =>  Tshirt::where('encomenda_id', '=', $encomenda->id)->get(),
                'encomenda' =>  $encomenda
            );

            Mail::to(Auth::user()->email)->queue(new SendMail($data));


            return back()
                ->with('alert-msg', 'A sua compra foi efetuada! Verifique a fatura no seu Email')
                ->with('alert-type', 'success');

        } catch (\Throwable $th) {

            DB::rollBack();

            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - TshirtController (store)',
                'message'   =>   $th->getMessage()
            );

            Mail::to(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MAGICTSHIRTS.com'))->queue(new SendMail($data));

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
