
$('#tipo_pagamento').on('change', function() {

    if (this.value == 'PAYPAL') {
        $("#ref_pagamento").attr('placeholder', 'Email');
    } else {
        $("#ref_pagamento").attr('placeholder', 'Referência do pagamento');
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

    $('#formAlterarCarrinho').attr('action', $('#formUpdateCarrinho'+key).attr('action'));

    $('#previewImageModal').attr('src', $('#previewImage'+key).attr('src'));
    $('#inputTamanho').val($('#tamanho'+key).attr('data-size'));
    $( '#colorinputCorModal' ).css( "background-color" , $( '#colorInputCor'+key ).css( "background-color" ) );
    $('#inputCorModal').val($('#cor'+key).attr('data-color'));
    $('#inputQuantidade').val($('#quantidade'+key).attr('data-qtd'));
    $('#inputQuantidade').attr('data-key', key);
    if (parseInt($('#quantidade'+key).attr('data-qtd')) >= parseInt($('#quantidadeDesconto').val())) {
        if ($('#precoUn'+key) > 0) {
            $('#inputPrecoUni').val($('#valorPropDesconto').val());
        } else {
            $('#inputPrecoUni').val($('#valorPubDesconto').val());
        }
    } else {
        if ($('#precoUn'+key) > 0) {
            $('#inputPrecoUni').val($('#valorPropSemDesconto').val());
        } else {
            $('#inputPrecoUni').val($('#valorPubSemDesconto').val());
        }
    }

    $('#inputSubTotal').val(($('#inputPrecoUni').val() * $('#inputQuantidade').val()).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
}

document.getElementById('inputQuantidade').onchange = function () {
    var key = $('#inputQuantidade').attr('data-key');
    if (parseInt(this.value) >= parseInt($('#quantidadeDesconto').val())) {
        if ($('#precoUn'+key) > 0) {
            $('#inputPrecoUni').val($('#valorPropDesconto').val());
        } else {
            $('#inputPrecoUni').val($('#valorPubDesconto').val());
        }
    }else {
        if ($('#precoUn'+key) > 0) {
            $('#inputPrecoUni').val($('#valorPropSemDesconto').val());
        } else {
            $('#inputPrecoUni').val($('#valorPubSemDesconto').val());
        }
    }

    $('#inputSubTotal').val(($('#inputPrecoUni').val() * $('#inputQuantidade').val()).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));

};

document.getElementById('inputCorModal').onchange = function() {
    document.getElementById('colorinputCorModal').style.backgroundColor = '#'+this.value;
    $("#previewImageModal").attr('src', $("#previewImageModal").attr('src').replace(/([a-fA-F0-9]{6}|[a-fA-F0-9]{3})/,this.value));
};


