@extends('layout')
@section('title','Carrinho de compras' )
@section('content')
<div>
  <p>Go to <a href="{{ action([App\Http\Controllers\EmailController::class, 'index']) }}">EMail</a> page</p>
  <p>
    Go to <a href="{{ action([App\Http\Controllers\PlaygroundController::class, 'index']) }}">Playground</a> page
  </p>
  <p>Go to <a href="{{ action([App\Http\Controllers\DisciplinaController::class, 'index']) }}">Disciplinas</a> page</p>
</div>
<hr>
<div>
  <p>
        <form action="{{ route('carrinho.destroy') }}" method="POST">
            @csrf
            @method("DELETE")
            <input type="submit" value="Apagar carrinho">
        </form>
  </p>
  <p>
        <form action="{{ route('carrinho.store') }}" method="POST">
            @csrf
            <input type="submit" value="Confirmar carrinho">
        </form>
  </p>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Quantity</th>
            <th>Course</th>
            <th>Year</th>
            <th>Sem.</th>
            <th>Abr.</th>
            <th>Name</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($carrinho as $row)
    <tr>
        <td>{{ $row['qtd'] }} </td>
        <td>{{ $row['curso'] }} </td>
        <td>{{ $row['ano'] }} </td>
        <td>{{ $row['semestre'] }} </td>
        <td>{{ $row['abreviatura'] }} </td>
        <td>{{ $row['nome'] }} </td>
        <td>
            <form action="{{route('carrinho.update_disciplina', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="1">
                <input type="submit" value="Increment">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.update_disciplina', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="-1">
                <input type="submit" value="Decrement">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.destroy_disciplina', $row['id'])}}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Remove">
            </form>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>

