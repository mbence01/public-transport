function fillForm(data) {
    var splitted = data.split(',');

    document.getElementById("input_megnevezes").value = splitted[0];
    document.getElementById("input_menetido").value = splitted[1];
    document.getElementById("input_megallok_szama").value = splitted[2];
}