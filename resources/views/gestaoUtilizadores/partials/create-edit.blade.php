<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="name" id="inputNome" value="{{old('name', $user->name)}}" >
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="text" class="form-control" name="email" id="inputEmail" value="{{old('email', $user->email)}}" >
    @error('email')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div class="form-check form-check-inline">
        <input type="hidden" name="admin" value="0">
        <input type="checkbox" class="form-check-input" id="inputAdmin" name="admin" value="1" {{old('admin', $user->admin) == '1' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputAdmin">
            Administrador
        </label>
    </div>
    @error('admin')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div>Género</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input ml-4" id="inputFuncionario" name="tipo" value="F" {{old('tipo',  $user->tipo) == 'F' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputFeminino"> Feminino </label>
        <input type="radio" class="form-check-input ml-4" id="inputAdmin" name="tipo" value="A" {{old('genero',  $user->tipo) == 'A' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputFeminino"> Feminino </label>
    </div>
    @error('tipo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputFoto">Upload da foto</label>
    <input type="file" class="form-control" name="foto" id="inputFoto">
    @error('foto')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
