$('#tipo_pagamento').on('change', function() {

    if (this.value == 'PAYPAL') {
        $("#ref_pagamento").attr('disabled', 'disabled');
        $("#ref_pagamento_div").attr('disabled', 'disabled');
    } else {
        $('#ref_pagamento').removeAttr('disabled');
        $('#ref_pagamento_div').removeAttr('disabled');
    }
});

$(function() {
    var total = 0;
    $('.subtotal').each(function( index ) {
        var subtotal = parseFloat($( this ).text(), 10);
        total += subtotal;
    });
    $('#totalOrder').html(total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
});

function alterarCarrinhoLoadRow(key) {
    $('#previewImageModal').attr('src', $('#previewImage'+key).attr('src'));
    $('#inputTamanho option[value='+$('#tamanho'+key).text()+']').attr('selected','selected');
}
/*
$(function(){ // let all dom elements are loaded
    $('#alterarCarrinhoModal').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        alert(btn.val());
        $('#previewImageModal').attr('src', $('#previewImage'+e.relatedTarget.value).attr('src'));
        //$('#previewImageModal option[value='+$('#')+']').attr('selected','selected');
        $('#inputTamanho').attr('src', $('#previewImage'+e.relatedTarget.value).attr('src'));
        $('#previewImageModal').attr('src', $('#previewImage'+e.relatedTarget.value).attr('src'));
        $('#previewImageModal').attr('src', $('#previewImage'+e.relatedTarget.value).attr('src'));
      });
});*/


