function fillForm(data) {
    var splitted = data.split(',');

    document.getElementById("input_nev").value = splitted[0];
    document.getElementById("input_szemelyi_szam").value = splitted[1];
    document.getElementById("input_csatlakozas_datuma").value = splitted[2];
}