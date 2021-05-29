<div class="row">
    <div class="form-group col-6">
        <label for="inputCategoria">Categoria</label>
        <select class="form-control" name="categoria_id" id="inputCategoria">
            <option value="" selected>Escolher categoria...</option>
            @foreach ($categorias as $abr => $nome)
            <option value={{$abr}} {{$abr == old('categoria_id', $estampa->categoria_id) ? 'selected' : ''}}>{{$nome}}</option>
            @endforeach
        </select>
        @error('categoria_id')
            <div class="small text-danger">{{$message}}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="form-group col">
        <label for="inputNome">Nome</label>
        <input type="text" class="form-control" placeholder="Nome" name="nome" id="inputNome" value="{{old('nome', $estampa->nome)}}" >
        @error('nome')
            <div class="small text-danger">{{$message}}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="form-group col">
        <label for="inputDescricao">Descrição</label>
        <textarea rows="3" class="form-control" name="descricao" id="inputDescricao" >{{old('descricao', $estampa->descricao)}}</textarea>
        @error('descricao')
            <div class="small text-danger">{{$message}}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="form-group col">
        <label class="" for="inputFoto">Foto da estampa</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="imagem_url" id="inputFoto">
            <label id="lblimagem_url" class="custom-file-label" for="inputFoto">{{$estampa->imagem_url == null ? 'Selecione uma foto' : 'Já selecionada'}}</label>
            @error('imagem_url')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
    </div>
</div>
