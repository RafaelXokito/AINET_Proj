<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaPost;
use App\Mail\SendMail;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CategoriasController extends Controller
{
    public function index(Request $request)
    {
        $qry = Categoria::query();

        $apagadoSelected = $request->apagado ?? '';
        $nomeSelected = $request->nome ?? '';

        if ($apagadoSelected == 'deleted') {
            $qry->onlyTrashed();
        } elseif ($apagadoSelected == 'all') {
            $qry->withTrashed();
        }
        if ($nomeSelected != '') {
            $qry->where('nome', 'LIKE', '%'.$request->nome.'%');
        }
        $listaCategorias = $qry->orderBy('nome')->paginate(10);
        return view('categorias.index')
            ->withNome($nomeSelected)
            ->withApagado($apagadoSelected)
            ->withCategorias($listaCategorias);
    }

    public function store(CategoriaPost  $request)
    {
        $validatedData = $request->validated();
        $newCategoria = new Categoria;
        $newCategoria->nome = $validatedData['nome'];
        try {
            $newCategoria->save();
            return redirect()->route('categorias')
                ->with('alert-msg', 'A categoria '.$newCategoria->nome.' foi criada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - TshirtController (store)',
                'message'   =>   $th->getMessage()
            );

            Mail::to(env('DEVELOPER_MAIL_USERNAME', 'GERAL@MAGICTSHIRTS.com'))->queue(new SendMail($data));
            return redirect()->route('categorias')
                ->with('alert-msg', 'A categoria '.$newCategoria->nome.' foi não criada com sucesso!')
                ->with('alert-type', 'danger');
        }


    }

    public function update(CategoriaPost  $request, Categoria $categoria)
    {
        $validatedData = $request->validated();
        $categoria = Categoria::findOrFail($categoria->id);
        $categoria->nome = $validatedData['nome'];
        $categoria->save();

        return redirect()->route('categorias')
            ->with('alert-msg', 'A categoria '.$categoria->nome.' foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function delete(Categoria $categoria)
    {
        $oldName = $categoria->nome;
        $oldCategoriaID = $categoria->id;
        try {
            $categoria->delete();
            Categoria::destroy($oldCategoriaID);
            return redirect()->back()
                ->with('alert-msg', 'Categoria "' . $oldName . '" foi apagado com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->back()
                    ->with('alert-msg', 'Não foi possível apagar o Categoria "' . $oldName . '", porque este user já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->back()
                    ->with('alert-msg', 'Não foi possível apagar o Categoria "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function restore($id)
    {
        $categoria = Categoria::withTrashed()->findOrFail($id);
        $this->authorize('restore', $categoria);
        try {
            $categoria->restore();
            return redirect()->back()
                    ->with('alert-msg', 'Categoria "' . $categoria->nome . '" foi recuperado com sucesso!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->back()
                    ->with('alert-msg', 'Não foi possível restaurar o Categoria "' . $categoria->nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }

    public function forceDelete($id)
    {
        $categoria = Categoria::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $categoria);
        $nome = $categoria->nome;
        try {
            $categoria->forceDelete();
            return redirect()->back()
                    ->with('alert-msg', 'A categoria "' . $nome . '" foi apagada para sempre!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->back()
                    ->with('alert-msg', 'Não foi possível apagar a categoria "' . $nome . '", porque esta já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->back()
                    ->with('alert-msg', 'Não foi possível apagar a categoria "' . $nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }

        }
    }
}
