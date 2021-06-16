
function forceDeleteClicked(id, nome) {
    $('#usersNomeModal').html(nome);
    $('#usersBtnSubmitModal').attr('form', 'forceDeleteForm'+id);
}
