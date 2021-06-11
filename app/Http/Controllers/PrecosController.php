<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrecoPost;
use App\Models\Preco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class PrecosController extends Controller
{
    public function edit()
    {
        $precos = Preco::first();
        return view('precos.edit')
            ->withPrecos($precos);
    }

    public function update(PrecoPost $request, Preco $precos)
    {
        try {
            $validated_data = $request->validated();

            $precos = Preco::find($precos->id);

            $precos->preco_un_catalogo = $validated_data['preco_un_catalogo'];
            $precos->preco_un_proprio = $validated_data['preco_un_proprio'];
            $precos->preco_un_catalogo_desconto = $validated_data['preco_un_catalogo_desconto'];
            $precos->preco_un_proprio_desconto = $validated_data['preco_un_proprio_desconto'];
            $precos->quantidade_desconto = $validated_data['quantidade_desconto'];
            $precos->save();

            return redirect()->route('precos.edit')
                ->with('alert-msg', 'Página de preços alterada com sucesso!')
                ->with('alert-type', 'success')
                ->withPrecos($precos);
        } catch (\Throwable $th) {

            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - PrecoController',
                'message'   =>   $th->getMessage()
            );

            Mail::to(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MAGICTSHIRTS.com'))->queue(new SendMail($data));
            return redirect()->route('precos.edit')
                ->withPrecos($precos)
                ->with('alert-msg', 'Página de preços NÃO alterada com sucesso!')
                ->with('alert-type', 'danger');
        }
    }
}
