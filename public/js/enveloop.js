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


//Script para validar vaores em dinheiro
(function ($, undefined) {

    "use strict";

    // When ready.
    $(function () {

        var $form = $(".input-money");
        var $input = $form.find("input");

        $input.on("keyup", function (event) {


            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if (selection !== '') {
                return;
            }

            // When the arrow keys are pressed, abort.
            if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                return;
            }


            var $this = $(this);

            // Get the value.
            var input = $this.val();

            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt(input, 10) : 0;

            $this.val(function () {
                var valuefinal = (input === 0) ? "" : input / 100;
                return valuefinal.toLocaleString("pt-BR", {style: "currency", currency: "BRL"})
            });
        });
    });
})(jQuery);


//validate form
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();