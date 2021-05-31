
var coresUrl = $('#formStoreUpdate').attr('action');
var tshirtsPath = $('#inputUploadedFotoModal').attr('src');

function alterarOnClick(id, nome) {
    $('#inputFotoModalLabel').html('Foto Selecionada');
    $('#formStoreUpdate').attr('action', coresUrl +'/'+id+'/update');
    $('#modalTitle').html('Alterar Cor');
    $('#modalCriarBtn').html('Alterar');
    $('#inputNomeModal').val(nome);
    $('#inputCodigoModal').val(id.toUpperCase());
    $('#inputUploadedFotoModal').attr('src', tshirtsPath + id + '.jpg');
    $('#inputFotoModal').prop('files', )
    if ($('#imageSelected').hasClass('d-none')) {
        $('#imageSelected').removeClass('d-none');
        $('#imageSelected').addClass('d-block');
    }
};

function criarOnClick() {
    $('#inputFotoModalLabel').html('Selecionar Foto');
    $('#inputUploadedFotoModal').attr('src', tshirtsPath);
    $('#formStoreUpdate').attr('action', coresUrl +'/store');
    $('#modalTitle').html('Criar Cor');
    $('#modalCriarBtn').html('Criar');
    $('#inputNomeModal').val('');
    $('#inputCodigoModal').val('');
    if ($('#imageSelected').hasClass('d-block')) {
        $('#imageSelected').removeClass('d-block');
        $('#imageSelected').addClass('d-none');
    }
};

document.getElementById('inputFotoModal').addEventListener('change', function () {
    if ($('#imageSelected').hasClass('d-none')) {
        $('#imageSelected').removeClass('d-none');
        $('#imageSelected').addClass('d-block');
    }
    var file = document.getElementById('inputFotoModal').files[0];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (e) {
        $('#inputUploadedFotoModal').attr('src', e.target.result);
    };
}, false)

