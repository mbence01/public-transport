$(document).ready(function(){
    $("#jaratok .jarat-record").click(function() {
        var jaratszam = $(this).find("span").text();

        $.get(
            "php/getbusdata.php",
            { "jarat" : jaratszam }
        ).done(function(data) {
            $("#bus-data").html(data);
        });
    });
});