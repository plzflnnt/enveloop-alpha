//autohide notifications
$(document).ready(function() {
    $("#message-home").fadeTo(40000, 500).slideUp(500, function(){
        $("#message-home").slideUp(500);
    });
});

//tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

//script para recuperar conteúdo de modal
function loadDoc(id) {
    /* Configura a requisição AJAX */
    $.ajax({
        url: '/tips/cardaprio', /* URL que será chamada */
        type: 'GET', /* Tipo da requisição */
        data: 'com_id=' + $('#com-id' + id).val(), /* dado que será enviado via GET */
        dataType: 'json', /* Tipo de transmissão */
        success: function (data) {
            if (data.sucesso == 1) {
                clearDiv(id);
                $('#value' + data.comercio).append(data.cardaprio);
            }
        }
    });
    return false;
}