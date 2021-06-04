@extends('layout')
@section('title','Alterar User' )
@section('content')
    <form method="POST" action="{{route('utilizadores.update', ['user' => $user]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{$user->id}}">
        @include('utilizadores.partials.create-edit')
        @if (Auth::user()->tipo == 'C')
        <div class="row">
            <div class="col">
                <label for="NIF">NIF</label>
                <div class="form-group">
                    <input type="text" placeholder="NIF" id="NIF" name="nif" aria-describedby="button-addon3" class="form-control">
                    @error('nif')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col">
                <label for="endereco">Morada</label>
                <div class="form-group">
                    <input type="text" placeholder="Morada" id="endereco" name="endereco" aria-describedby="button-addon3" class="form-control">
                    @error('endereco')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="tipo_pagamento">Tipo de Pagamento</label>
                <div class="form-group">
                    <select name="tipo_pagamento" id="tipo_pagamento" class="form-control">
                        <option value="vazio" selected>Método Pagamento</option>
                        <option value="VISA" aria-describedby="button-addon3"  class="form-control">VISA</option>
                        <option value="MC" aria-describedby="button-addon3" class="form-control">MC</option>
                        <option value="PAYPAL" aria-describedby="button-addon3" class="form-control">PAYPAL</option>
                    </select>

                    @error('tipo_pagamento')
                        <div class="small text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col">
                <label for="ref_pagamento_div">Referência de Pagamento</label>
                <div class="form-group" id="ref_pagamento_div">
                    <input id="ref_pagamento" name="ref_pagamento" type="text" placeholder="Referencia do pagamento" aria-describedby="button-addon3" class="form-control">
                </div>
                @error('ref_pagamento')
                    <div class="small text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        @endif
        @isset($user->foto_url)
            <div class="form-group">
                <img src="{{$user->foto_url ? asset('storage/fotos/' . $user->foto_url) : asset('img/default_img.png') }}"
                     alt="Foto do user"  class="img-profile"
                     style="max-width:100%">
            </div>
        @endisset
        <div class="form-group text-right">
            @isset($user->foto_url)
                @can('update', $user)
                    <button type="submit" class="btn btn-danger" name="deletefoto" form="form_delete_photo">Apagar Foto</button>
                @endcan
            @endisset
            @can('update', $user)
                <button type="submit" class="btn btn-success" name="ok">Save</button>
            @endcan
            <a href="{{route('utilizadores.edit', ['user' => $user]) }}" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
    <form id="form_delete_photo" action="{{route('utilizadores.foto.destroy', ['user' => $user])}}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection
