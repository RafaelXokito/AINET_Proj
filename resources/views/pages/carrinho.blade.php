@extends('layout')
@section('title','Carrinho de compras' )
@section('content')
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
            <th>Id da Estampa</th>
            <th>Quantidade</th>
            <th>Tamanho</th>
            <th>Cor</th>
            <th>Preço uni.</th>
            <th>SubTotal</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($carrinho as $row)
    <tr>
        <td>{{ $row['estampa_id'] }} </td>
        <td>{{ $row['quantidade'] }} </td>
        <td>{{ $row['tamanho'] }} </td>
        <td>{{ $row['cor_codigo'] }} </td>
        <td>{{ $row['preco_un'] }} </td>
        <td>{{ $row['subtotal'] }} </td>
        <td>
            <form action="{{route('carrinho.update_tshirt', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="1">
                <input type="submit" value="Increment">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.update_tshirt', $row['id'])}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="quantidade" value="-1">
                <input type="submit" value="Decrement">
            </form>
        </td>
        <td>
            <form action="{{route('carrinho.destroy_tshirt', $row['id'])}}" method="POST">
                @csrf
                @method('delete')
                <input type="submit" value="Remove">
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
