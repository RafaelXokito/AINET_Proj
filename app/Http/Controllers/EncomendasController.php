<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncomendaPost;
use App\Models\Encomenda;
use Illuminate\Http\Request;

class EncomendasController extends Controller
{
    public function index(Request $request)
    {
        $qry = Encomenda::query();

        $estadoSelected = $request->estado ?? '';

        if ($estadoSelected != '') {
            $qry->where('estado', '=', $request->estado);
        }
        $listaEncomendas = $qry->orderBy('estado')->paginate(10);
        return view('encomendas.index')
            ->withEstado($estadoSelected)
            ->withEncomendas($listaEncomendas);
    }

    public function store(EncomendaPost  $request)
    {
        $validatedData = $request->validated();
        $newEncomenda = new Encomenda;
        $newEncomenda->nome = $validatedData['nome'];
        $newEncomenda->save();

        return redirect()->route('encomendas')
            ->with('alert-msg', 'A categoria '.$newEncomenda->nome.' foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(EncomendaPost  $request, Encomenda $encomenda)
    {
        $validatedData = $request->validated();
        $encomenda = Encomenda::findOrFail($encomenda->id);
        $encomenda->estado = $validatedData['estado'];
        $encomenda->save();

        return redirect()->route('encomendas')
            ->with('alert-msg', 'O estado da escomenda foi alterado com sucesso!! O estado atual é '. $encomenda->estado)
            ->with('alert-type', 'success');
    }

    public function delete(Encomenda $categoria)
    {
        $oldName = $categoria->nome;
        $oldEncomendaID = $categoria->id;
        try {
            $categoria->delete();
            Encomenda::destroy($oldEncomendaID);
            return redirect()->route('encomendas')
                ->with('alert-msg', 'Encomenda "' . $oldName . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('encomendas')
                    ->with('alert-msg', 'Não foi possível apagar o Encomenda "' . $oldName . '", porque este user já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('encomendas')
                    ->with('alert-msg', 'Não foi possível apagar o Encomenda "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function restore($id)
    {
        $categoria = Encomenda::withTrashed()->findOrFail($id);
        $this->authorize('restore', $categoria);
        try {
            $categoria->restore();
            return redirect()->route('encomendas')
                    ->with('alert-msg', 'Encomenda "' . $categoria->nome . '" foi recuperado com sucesso!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('encomendas')
                    ->with('alert-msg', 'Não foi possível restaurar o Encomenda "' . $categoria->nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }


}
