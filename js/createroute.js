$(document).ready(function() {
    $("#stopcount").change(function() {
        var typedVal = $(this).val();
        var currVal = $("#stops-container").attr("count");
        var diff = typedVal - currVal;

        for(var i = 0; i < diff; i++) {
            $.ajax({
                url: "php/getstops.php",
                data: { 'count' : $("#stops-container").attr("count") }
            }).done(function(data) {
                $("#stops-container").append(data);
            });

            $("#stops-container").attr("count", parseInt($("#stops-container").attr("count")) + 1);
        }
    });
});