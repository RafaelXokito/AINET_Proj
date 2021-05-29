document.getElementById('inputFoto').onchange = function () {
    document.getElementById('lblimagem_url').textContent = this.files.item(0).name;
    document.getElementById('lblimagem_url').value = this.files.item(0).name;
    $('#changedImg').show(500);

};

document.getElementById('inputCor').onchange = function() {
    document.getElementById('colorInputCor').style.backgroundColor = '#'+this.value;
    $("#previewImage").attr('src','http://ainet_proj.test/estampas/'+ $('#estampa_id').val() +'/'+this.value+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
};

function inputOpacidadeChange(newValue) {
    $('#inputOpacidadeValue').html(newValue);
    $("#previewImage").attr('src','http://ainet_proj.test/estampas/'+ $('#estampa_id').val() +'/'+$('#inputCor').val()+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
}

function inputRotacaoChange(newValue) {
    $('#inputRotacaoValue').html(newValue+'º');
    $("#previewImage").attr('src','http://ainet_proj.test/estampas/'+ $('#estampa_id').val() +'/'+$('#inputCor').val()+'/'+$('#inputPosicao').val()+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');
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
    $("#previewImage").attr('src','http://ainet_proj.test/estampas/'+ $('#estampa_id').val() +'/'+$('#inputCor').val()+'/'+this.value+'/'+$('#inputRotacao').val()+'/'+$('#inputOpacidade').val()+'/preview');

};
