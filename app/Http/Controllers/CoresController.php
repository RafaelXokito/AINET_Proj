<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cores;
use App\Http\Requests\CoresPost;

class CoresController extends Controller
{
    public function index(Request $request)
    {
        $qry = Cores::query();

        $apagadoSelected = $request->apagado ?? '';
        $nomeSelected = $request->nome ?? '';
        $codigoSelected = $request->codigo ?? '';

        if ($apagadoSelected == 'deleted') {
            $qry->onlyTrashed();
        } elseif ($apagadoSelected == 'all') {
            $qry->withTrashed();
        }
        if ($nomeSelected != '') {
            $qry->where('nome', 'LIKE', '%'.$request->nome.'%');
        }
        if ($codigoSelected != '') {
            $qry->where('codigo', '=', $request->codigo);
        }

        $listaCores = $qry->orderBy('nome')->paginate(10);
        return view('cores.index')
            ->withCodigo($codigoSelected)
            ->withNome($nomeSelected)
            ->withApagado($apagadoSelected)
            ->withCores($listaCores);
    }

    public function store(CoresPost  $request)
    {
        $validatedData = $request->validated();
        $newCor = new Cores;
        $newCor->nome = $validatedData['nome'];
        $newCor->save();

        return redirect()->route('cores')
            ->with('alert-msg', 'A categoria '.$newCor->nome.' foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(CoresPost  $request, Cores $cor)
    {
        $validatedData = $request->validated();
        $cor = Cores::findOrFail($cor->id);
        $cor->nome = $validatedData['nome'];
        $cor->save();

        return redirect()->route('cores')
            ->with('alert-msg', 'A categoria '.$cor->nome.' foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function delete(Cores $cores)
    {
        $oldName = $cores->nome;
        $oldCorID = $cores->id;
        try {
            $cores->delete();
            Cores::destroy($oldCorID);
            return redirect()->route('cores')
                ->with('alert-msg', 'Cor "' . $oldName . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('cores')
                    ->with('alert-msg', 'Não foi possível apagar a Cor "' . $oldName . '", porque este user já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('cores')
                    ->with('alert-msg', 'Não foi possível apagar a Cor "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function restore($id)
    {
        try {
            $cor = Cores::withTrashed()->findOrFail($id);
            $cor->restore();
            return redirect()->route('cores')
                    ->with('alert-msg', 'Cor "' . $cor->nome . '" foi recuperado com sucesso!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('cores')
                    ->with('alert-msg', 'Não foi possível restaurar o Cor "' . $cor->nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }
}
