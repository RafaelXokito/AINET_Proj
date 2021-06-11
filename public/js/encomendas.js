
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
    alert($('#detalhes'+id));
    //$('#detalhes'+id).append('@include('encomendas.partials.detalhes')');
};

function alterarOnClickAppear(id) {
    Array.from($('.preview_encomenda'+id)).forEach(
        function(element, index, array) {
            element.setAttribute('src', element.getAttribute("data-src"));
        }
    );
};


