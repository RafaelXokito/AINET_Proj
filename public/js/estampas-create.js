document.getElementById('inputFoto').onchange = function () {
    document.getElementById('lblimagem_url').textContent = this.files.item(0).name;
    document.getElementById('lblimagem_url').value = this.files.item(0).name;
};
