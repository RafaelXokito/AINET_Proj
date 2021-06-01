function forceDeleteClicked(id, nome) {
    $('#estampaNomeModal').html(nome);
    $('#estampaBtnSubmitModal').attr('form', 'forceDeleteForm'+id);
}
