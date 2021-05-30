document.getElementById('inputFoto').onchange = function () {
    document.getElementById('lblimagem_url').textContent = this.files.item(0).name;
    document.getElementById('lblimagem_url').value = this.files.item(0).name;
    $('#changedImg').show(500);

};

var estampasUrl = $('#formAdicionarAoCarrinho').attr('action');

document.getElementById('inputCor').onchange = function() {
    document.getElementById('colorInputCor').style.backgroundColor = '#'+this.value;
    $("#previewImage").attr('src',estampasUrl+ '/'+ $('#estampa_id').val() +'/'+this.value+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
};

function inputOpacidadeChange(newValue) {
    $("#previewImage").attr('src',estampasUrl+ '/'+ $('#estampa_id').val() +'/'+$('#inputCor').val()+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
}

function inputOpacidadeOnInput(newValue) {
    $('#inputOpacidadeValue').html(newValue);
}

function inputRotacaoChange(newValue) {
    $("#previewImage").attr('src',estampasUrl+ '/'+ $('#estampa_id').val() +'/'+$('#inputCor').val()+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
}

function inputRotacaoOnInput(newValue) {
    $('#inputRotacaoValue').html(newValue+'º');
}

document.getElementById('inputPosicao').onchange = function() {
    switch (this.value) {
        case 'top':
            $('#inputPosicaoIcon').removeClass('bi-align-bottom');
            $('#inputPosicaoIcon').removeClass('bi-align-center');
            $('#inputPosicaoIcon').addClass('bi-align-top');
            break;
        case 'center':
            $('#inputPosicaoIcon').removeClass('bi-align-bottom');
            $('#inputPosicaoIcon').removeClass('bi-align-top');
            $('#inputPosicaoIcon').addClass('bi-align-center');
            break;
        case 'bottom':
            $('#inputPosicaoIcon').removeClass('bi-align-top');
            $('#inputPosicaoIcon').removeClass('bi-align-center');
            $('#inputPosicaoIcon').addClass('bi-align-bottom');
            break;
    }
    $("#previewImage").attr('src',estampasUrl+ '/'+ $('#estampa_id').val() +'/'+$('#inputCor').val()+'/'+this.value+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');

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
