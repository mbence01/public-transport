function fillForm(data) {
    var splitted = data.split(',');

    document.getElementById("input_rendszam").value = splitted[0];
    document.getElementById("input_tipus").value = splitted[1];
    document.getElementById("input_ev").value = splitted[2];
    document.getElementById("input_sofor").value =splitted[3];
}