<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cor;
use App\Http\Requests\CorPost;
use Illuminate\Support\Facades\Storage;

class CoresController extends Controller
{
    public function index(Request $request)
    {
        $qry = Cor::query();

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

    public function store(CorPost  $request)
    {

        $validatedData = $request->validated();
        $validatedFile = $request->validate(['foto' => 'required']);
        try {
            $newCor = new Cor;
            $newCor->codigo = strtolower($validatedData['codigo']);
            $newCor->nome = $validatedData['nome'];
            if ($request->has('foto')) {
                Storage::disk('public')->putFileAs('tshirt_base\\', $validatedFile['foto'], $validatedData['codigo'] . '.jpg');
            }
            $newCor->save();
            return redirect()->route('cores')
                ->with('alert-msg', 'A cor '.$newCor->nome.' foi criada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('cores')
                    ->with('alert-msg', 'A cor '.$newCor->nome.' não foi criada com sucesso! O código da cor deve ser único')
                    ->with('alert-type', 'danger');
            }
            return redirect()->route('cores')
                ->with('alert-msg', 'A cor '.$newCor->nome.' não foi criada com sucesso! ' . $th->errorInfo[1])
                ->with('alert-type', 'danger');
        }
    }

    public function update(CorPost  $request, Cor $cor)
    {
        $validatedData = $request->validated();
        try {

            $cor = Cor::findOrFail(strtolower($cor->codigo));
            $cor->codigo = strtolower($validatedData['codigo']);
            $cor->nome = $validatedData['nome'];
            if ($request->hasFile('foto')) {
                Storage::disk('public')->putFileAs('tshirt_base\\', $validatedData['foto'], $validatedData['codigo'] . '.jpg');
            }
            $cor->save();

            return redirect()->route('cores')
                ->with('alert-msg', 'A cor '.$cor->nome.' foi alterada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('cores')
                    ->with('alert-msg', 'A cor '.$cor->nome.' não foi alterada com sucesso! O código da cor deve ser único')
                    ->with('alert-type', 'danger');
            }
            return redirect()->route('cores')
                ->with('alert-msg', 'A cor '.$cor->nome.' não foi alterada com sucesso! ' . $th->errorInfo[1])
                ->with('alert-type', 'danger');
        }
    }

    public function delete(Cor $cor)
    {
        $oldName = $cor->nome;
        $oldCorID = $cor->codigo;
        try {
            $cor->delete();
            Cor::destroy($oldCorID);
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

    public function restore($codigo_cor)
    {
        $cor = Cor::withTrashed()->findOrFail($codigo_cor);
        $this->authorize('restore', $cor);
        try {
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
