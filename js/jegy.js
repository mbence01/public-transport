$(document).ready(function(){
    $("#checkbox-text").click(function() {
        $("#checkbox").prop("checked", !$("#checkbox").prop("checked"));
        $("#checkbox").change();
    });

    $("#checkbox").change(function() {
        if(this.checked) {
            $("#email").prop('readonly', false);
        } else {
            $("#email").prop('readonly', true);
        }
    });
});