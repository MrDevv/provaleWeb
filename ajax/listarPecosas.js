$(document).ready(function () {

    let fechaActual = new Date();
    let fechaFormateada = fechaActual.toISOString().split('T')[0];

// nuva pecosa - abrir modal
    $(document).off("click", "#nuevaPecosa").on("click", "#nuevaPecosa", function(e) {
        e.preventDefault();
        let modalRegistrar = $("#modalRegistrarPecosa");
        $("#registrarPecosaForm").trigger("reset");
        $("#fechaReparto").val(fechaFormateada)
        $("#fechaDesde").val(fechaFormateada)

        modalRegistrar.modal({
            backdrop: 'static',
            keyboard: false
        });

        modalRegistrar.modal('show');

        modalRegistrar.one('shown.bs.modal', function() {
            $("#comite").focus();
        });
    });
})