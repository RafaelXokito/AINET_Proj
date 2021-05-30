
var estampasUrl = $('#formAdicionarAoCarrinho').attr('action');

document.getElementById('inputCor').onchange = function() {
    document.getElementById('colorInputCor').style.backgroundColor = '#'+this.value;
    $("#previewImage").attr('src',estampasUrl+ $('#estampa_id').val() +'/'+this.value+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
};

//adicionar ao carrinho
document.getElementById('inputQuantidade').onchange = function () {
    if (parseInt(this.value) >= parseInt($('#quantidadeDesconto').val())) {
        $('#inputPrecoUni').val($('#valorDesconto').val());
    }else {
        $('#inputPrecoUni').val($('#valorSemDesconto').val());
    }

    $('#inputSubTotal').val(parseFloat(this.value * $('#inputPrecoUni').val(), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
};
