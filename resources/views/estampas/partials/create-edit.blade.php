<br>
<hr>
<br>
<div class="form-group col-3">
    <label for="inputCategoria">Categoria</label>
    <select class="form-control" name="categoria" id="inputCategoria">
        @foreach ($categorias as $abr => $nome)
           <option value={{$abr}} {{$abr == old('categoria', $estampa->categoria) ? 'selected' : ''}}>{{$nome}}</option>
        @endforeach
    </select>
    @error('categoria')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group col-6">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" placeholder="Nome" name="name" id="inputNome" value="{{old('name', $estampa->name)}}" >
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group col-6">
    <label for="inputDescricao">Descrição</label>
    <textarea rows="3" class="form-control" name="descricao" id="inputDescricao" value="{{old('descricao', $estampa->descricao)}}" ></textarea>
    @error('descricao')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group col-6">
    <label class="" for="inputFoto">Foto da estampa</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="foto" id="inputFoto">
        <label class="custom-file-label" for="inputFoto">Selecione uma foto</label>
        @error('foto')
            <div class="small text-danger">{{$message}}</div>
        @enderror
    </div>
</div>
