
/*$('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});*/
var encomendasUrl = $('#formUpdate').attr('action');
function alterarOnClick(id, estado) {
    $('#inputEstadoModal').attr('form', 'formUpdate');
    $('#formUpdate').attr('action', encomendasUrl +'/'+id+'/update');
    $('#modalTitle').html('Alterar Estado da Encomenda');
    $('#modalCriarBtn').html('Alterar');
    $('#inputNomeModal').val(estado);
};


