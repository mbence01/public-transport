$(document).ready(function(){
    $("#bus-data").hide();

    $("#jaratok .jarat-record").click(function() {
        var jaratszam = $(this).find("span").text();

        $.get(
            "php/getbusdata.php",
            { "jarat" : jaratszam }
        ).done(function(data) {
            $("#bus-data").html(data);
            $("#bus-data").show(1000);
        });
    });
});