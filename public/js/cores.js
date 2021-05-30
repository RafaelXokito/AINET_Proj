
var coresUrl = $('#formStoreUpdate').attr('action');
function alterarOnClick(id, nome) {
    $('#formStoreUpdate').attr('action', coresUrl +'/'+id+'/update');
    $('#modalTitle').html('Alterar Cor');
    $('#modalCriarBtn').html('Alterar');
    $('#inputNomeModal').val(nome);
    $('#inputCodigoModal').val(id.toUpperCase());

};

function criarOnClick() {
    $('#formStoreUpdate').attr('action', coresUrl +'/store');
    $('#modalTitle').html('Criar Cor');
    $('#modalCriarBtn').html('Criar');
    $('#inputNomeModal').val('');
    $('#inputCodigoModal').val('');

};

document.getElementById('inputFotoModal').onchange = function () {
    if ($('#imageSelected').hasClass('d-none')) {
        $('#imageSelected').addClass('d-block');
    }
    var file = document.getElementById('inputFotoModal').files[0];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (e) {
        $('#inputUploadedFotoModal').attr('src', e.target.result);
    };
}

