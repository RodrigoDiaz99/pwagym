
const comandaTable = $('#gridPedidosComanda');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

});

//#region funciones

//#endregion

//#region onEvent
$("#btnGuardarConfiguracion").on("click", function () {
    let numero_orden = $("#numero_orden").val();
    $.ajax({
        url: routeGuardarConfiguracion,
        type: "post",
        dataType: "json",
        encoding: "UTF-8",
        data: {
            numero_orden: numero_orden,
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Guardando',
                text: 'Guardando, espere un momento...',
            });
            Swal.showLoading();
        },
        success: function (data) {
            Swal.close();
            if (data.lSuccess) {
                Swal.fire({
                    title: "Correcto",
                    text: "Se aplicaron los cambios correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: data.cMensaje,
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
            }
        },
        error: function () {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error desconocido.",
                icon: "error",
                confirmButtonText: "Aceptar",
            });
        }
    })
})

$(".number").on("input", function () {
    let inputValue = $(this).val();
    inputValue = inputValue.replace(/[^\d]+/g, '');
    if (inputValue != '' && inputValue <= 0) {
        inputValue = 1;
    }
    $(this).val(inputValue);
});
//#endregion


//#region formatters

//#endregion
