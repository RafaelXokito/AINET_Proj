
var categoriasUrl = $('#formUpdate').attr('action');
function alterarOnClick(id, nome) {
    $('#inputNomeModal').attr('form', 'formUpdate');
    $('#modalCriarBtn').attr('form', 'formUpdate');
    $('#formUpdate').attr('action', categoriasUrl +'/'+id+'/update');
    $('#modalTitle').html('Alterar Categoria');
    $('#modalCriarBtn').html('Alterar');
    $('#inputNomeModal').val(nome);
};

function criarOnClick() {
    $('#inputNomeModal').attr('form', 'formStore');
    $('#modalCriarBtn').attr('form', 'formStore');
    $('#modalTitle').html('Criar Categoria');
    $('#modalCriarBtn').html('Criar');
    $('#inputNomeModal').val('');
};

function forceDeleteClicked(id, nome) {
    $('#categoriaNomeModal').html(nome);
    $('#categoriaBtnSubmitModal').attr('form', 'forceDeleteForm'+id);
}

