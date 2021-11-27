var jaratszam = '';

$(document).ready(function(){
    $("#bus-data").hide();

    $("#jaratok .jarat-record").click(function() {
        jaratszam = $(this).find("span").text();

        $.get(
            "php/getschedule.php",
            { "jarat" : jaratszam }
        ).done(function(data) {
            $("#bus-data").html(data);
            $("#bus-data").show(1000);
        });
    });
});

function btnClick(element) {
    var day = "hétvége";

    if(element.getAttribute("day") == "hétvége")
        day = "hétköznap"

    $.get(
        "php/getschedule.php",
        { "jarat" : jaratszam, "day" : day }
    ).done(function(data) {
        $("#bus-data").html(data);
        $("#bus-data").show(1000);

        element.setAttribute("day", day);
        element.textContent = "Váltás " + day + "i menetrendre";
    });
}