<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncomendaPost;
use App\Http\Requests\UpdateEstadoEncomendaPost;
use App\Jobs\GenerateInvoiceJob;
use App\Jobs\SendEmailJob;
use App\Mail\SendMail;
use App\Models\Encomenda;
use App\Models\Estampa;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\File as File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class EncomendasController extends Controller
{
    public function index(Request $request)
    {
        $qry = Encomenda::query();

        $estadoSelected = $request->estado ?? '';
        $nomeSelected = $request->nome ?? '';
        $dataInicial = $request->dataInicial ?? '';
        $dataFinal = $request->dataFinal ?? '';

        $qry->select('encomendas.*');

        if ($estadoSelected != '') {
            $qry->where('encomendas.estado', '=', $estadoSelected);
        }
        if ($nomeSelected != '') {
            $qry->join('users', 'users.id', '=', 'encomendas.cliente_id');
            $qry->where('users.name', 'like', '%'.$nomeSelected.'%');
        }

        if ($dataInicial != '' && $dataFinal != '') {
            $qry->whereBetween('encomendas.data', [$dataInicial, $dataFinal]);
        }

        if (Auth::user()->tipo == 'F') {
            $qry->whereIn('encomendas.estado', ['pendente' ,'paga']);
        }
        if (Auth::user()->tipo == 'C') {
            $qry->where('encomendas.cliente_id', '=', Auth::user()->id);
        }



        $qry->orderBy('encomendas.data', 'desc');
        $qry->orderBy('encomendas.estado', 'asc');
        $qry->orderBy('encomendas.id', 'desc');

        $listaEncomendas = $qry->orderBy('estado')->paginate(10);
        return view('encomendas.index')
            ->withDataInicial($dataInicial)
            ->withDataFinal($dataFinal)
            ->withEstado($estadoSelected)
            ->withNome($nomeSelected)
            ->withEncomendas($listaEncomendas);
    }

    public function store(EncomendaPost  $request)
    {
        $validatedData = $request->validated();
        $newEncomenda = new Encomenda;
        $newEncomenda->nome = $validatedData['nome'];
        $newEncomenda->save();

        return redirect()->route('encomendas')
            ->with('alert-msg', 'A encomenda '.$newEncomenda->nome.' foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function updateEstado(UpdateEstadoEncomendaPost  $request, Encomenda $encomenda)
    {

        $validatedData = $request->validated();
        $encomenda = Encomenda::findOrFail($encomenda->id);

        if ($validatedData['estado'] != 'pendente' && $encomenda->estado != $validatedData['estado']) {

            $encomenda->estado = $validatedData['estado'];
            $encomenda->save();

            $data = array(
                'name'      =>  env('APP_NAME', 'fallback_app_name').' - Fatura Simplificada',
                'message'   =>  '',
                'tshirts'   =>  Tshirt::where('encomenda_id', '=', $encomenda->id)->get(),
                'encomenda' =>  $encomenda
            );

            switch ($encomenda->estado) {
                case 'paga':
                    $data['message'] = 'encomenda_paga';
                    break;
                case 'fechada':
                    $data['message'] = 'encomenda_fechada';
                    break;
                case 'anulada':
                    $data['message'] = 'encomenda_anulada';
                    break;
                default:
                    break;
            }

            $newMail = new SendMail($data);
            $newMail->to($encomenda->cliente->user->email);
            GenerateInvoiceJob::withChain([
                new SendEmailJob($data),
            ])->dispatch($data);
            //GenerateInvoiceJob::dispatch($data);
            //dispatch(new \App\Jobs\GenerateInvoiceJob($data));
            //Mail::to($encomenda->cliente->user->email)->queue(new SendMail($data));

        } else {
            return redirect()->route('encomendas')
                ->with('alert-msg', 'O estado da escomenda não pode voltar a ser pendente!! O estado atual é '. $encomenda->estado)
                ->with('alert-type', 'danger');
        }
        return redirect()->route('encomendas')
            ->with('alert-msg', 'O estado da escomenda foi alterado com sucesso!! O estado atual é '. $encomenda->estado)
            ->with('alert-type', 'success');
    }



    public function viewPdf(Encomenda $encomenda)
    {
        if (Storage::exists('pdf_recibos\recibo_'.$encomenda->id.'.pdf')) {
            return response()->file(storage_path('app\pdf_recibos\recibo_'.$encomenda->id.'.pdf'));
        } else {
            return redirect()->route('encomendas')
                ->with('alert-msg', 'O recibo não foi encontrado, por favor solicite a ajuda da equipa tecnica! Encomenda: '. $encomenda->id)
                ->with('alert-type', 'danger');
        }
    }

    public function delete(Encomenda $encomenda)
    {
        $oldName = $encomenda->nome;
        $oldEncomendaID = $encomenda->id;
        try {
            $encomenda->delete();
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
        $encomenda = Encomenda::withTrashed()->findOrFail($id);
        $this->authorize('restore', $encomenda);
        try {
            $encomenda->restore();
            return redirect()->route('encomendas')
                    ->with('alert-msg', 'Encomenda "' . $encomenda->nome . '" foi recuperado com sucesso!')
                    ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('encomendas')
                    ->with('alert-msg', 'Não foi possível restaurar o Encomenda "' . $encomenda->nome . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
        }
    }


}
