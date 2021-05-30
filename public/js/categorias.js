
var categoriasUrl = $('#formStoreUpdate').attr('action');
function alterarOnClick(id, nome) {
    $('#formStoreUpdate').attr('action', categoriasUrl +'/'+id+'/update');
    $('#modalTitle').html('Alterar Categoria');
    $('#modalCriarBtn').html('Alterar');
    $('#inputNomeModal').val(nome);
};

function criarOnClick() {
    $('#formStoreUpdate').attr('action', categoriasUrl +'/store');
    $('#modalTitle').html('Criar Categoria');
    $('#modalCriarBtn').html('Criar');
    $('#inputNomeModal').val('');
};

