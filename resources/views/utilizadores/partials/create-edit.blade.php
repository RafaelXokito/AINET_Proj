<div class="form-group">
    <!-- Nome -->
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="name" id="inputNome" value="{{old('name', $user->name)}}" >
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
@if (Route::currentRouteName()!='utilizadores.edit')
    <!-- Email -->
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="text" class="form-control" name="email" id="inputEmail" value="{{old('email', $user->email)}}" >
        @error('email')
            <div class="small text-danger">{{$message}}</div>
        @enderror
    </div>
@endif

@can('isAdmin', App\Models\User::class)
<div class="form-group">
    <!-- Bloquear -->
    <div class="form-check form-check-inline">
        <input type="hidden" name="bloqueado" value="0">
        <input type="checkbox" class="form-check-input" id="inputBloqueado" name="bloqueado" value="1" {{old('bloqueado', $user->bloqueado) == '1' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputBloqueado">
            Bloquear
        </label>
    </div>
    @error('bloqueado')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <!-- Tipo User -->
    <div>Tipo de User</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input ml-4" id="inputFuncionario" name="tipo" value="F" {{old('tipo',  $user->tipo) == 'F' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputFuncionario"> Funcionário </label>
        <input type="radio" class="form-check-input ml-4" id="inputAdmin" name="tipo" value="A" {{old('tipo',  $user->tipo) == 'A' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputAdmin"> Administrador </label>
    </div>
    @error('tipo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
@endcan

<div class="form-group">
    <!-- Foto -->
    <label for="inputFoto">Upload da foto</label>
    <input type="file" class="form-control" name="foto" id="inputFoto">
    @error('foto')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
