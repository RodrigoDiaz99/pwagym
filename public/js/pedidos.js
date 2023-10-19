

const pedidosTable = $('#gridPedidos');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    pedidosTable.bootstrapTable({
        url: routeGetPedidos,
        uniqueId: 'id',
        showFooter: true,
        columns: [
            {
                field: 'inventario',
                visible: false
            },
            {
                field: 'cantidad_producto',
                visible: false
            },
            {
                id: 'id',
                visible: false
            },
            {
                title: "No. Orden",
                field: "numero_orden"

            },
            {
                field: 'linea_referencia',
                title: 'Línea de referencia',
            },
            {
                field: 'estatus',
                title: 'Estado',
                width: 35,
                widthUnit: "%",
            },
            {
                field: 'precio',
                title: 'Total',
                formatter: PrecioFormatter
            },

            {
                title: 'Acciones',

                formatter: AccionesFormatter,
            }]
    })

});

//#region funciones
function cambiarEstatus(id, estatus) {
    $.ajax({
        url: routeCambiarEstatus,
        type: "post",
        encoding: "UTF-8",
        async: true,
        cache: false,
        data: {
            id: id,
            estatus: estatus,
            motivoCancelacion: $("#motivoCancelacion").val()
        },
        beforeSend: function () {
            Swal.fire({
                title: "Aviso",
                text: "Validando Cambios",
                didOpen: () => {
                    swal.showLoading();
                },
            });
        },
        success: function (data) {
            console.log(data);
            Swal.close();
            NProgress.done();
            if (data.lSuccess == true) {
                swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "Estatus actualizado correctamente",
                    confirmButtonText: "Aceptar",
                });
                pedidosTable.bootstrapTable('refresh');
            } else {
                Swal.fire({
                    title: "Error",
                    text: data.cMensaje,
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
            }

        },
        error: function (err) {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error desconocido.",
                icon: "error",
                confirmButtonText: "Aceptar",
            });
            alert(err);
        },
    });
}

function cancelarPedido(id) {
    $("#tituloCancelarPedido").text(`Cancelar pedido #${id}`)
    $("#motivoCancelacion").val("");
    $("#pedidos_id").val(id);
    $("#modalCancelarPedido").modal("show");
}

//#endregion

//#region onEvent
$("#btnCancelarPedido").on("click", function () {

})

//#endregion


//#region formatters

function PrecioFormatter(value, row) {
    return '$' + value;
}


function AccionesFormatter(value, row) {
    let html = "";
    console.log(row.estatus);
    html +=
        '<a href="javascript:void(0);" onclick="detalles(' +
        row.id +
        ')" class="btn btn-round btn-primary" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-info-circle"></i></a>&nbsp;';
    switch (row.estatus) {

        case "ENVIADO":
            html +=
                '<a href="javascript:void(0);" onclick="cambiarEstatus(' +
                row.id +
                "," +
                "'ACEPTADO'" +
                ')" class="btn btn-round btn-success" rel="tooltip" data-toggle="tooltip" title="Aceptar"><i class="fas fa-check"></i></a>&nbsp;';
            html +=
                '<a href="javascript:void(0);" onclick="cancelarPedido(' +
                row.id + ')" class="btn btn-round btn-danger" rel="tooltip" data-toggle="tooltip" title="Rechazar"><i class="fas fa-ban"></i></a>&nbsp;';
            break;
        case "ACEPTADO":
            console.log("entro")
            html +=
                '<a href="javascript:void(0);" onclick="cambiarEstatus(' +
                row.id +
                "," +
                "'PREPARACIÓN'" +
                ')" class="btn btn-round btn-warning" rel="tooltip" data-toggle="tooltip" title="Elaboracion"><i class="fas fa-retweet"></i></a>&nbsp;';
            console.log(html)
            break;
        case "PREPARACIÓN":
            html +=
                '<a href="javascript:void(0);" onclick="cambiarEstatus(' +
                row.id +
                "," +
                "'LISTO'" +
                ')" class="btn btn-round btn-warning" rel="tooltip" data-toggle="tooltip" title="Listo"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;

        case "LISTO":

            html +=
                '<a href="javascript:void(0);" onclick="cambiarEstatus(' +
                row.id +
                "," +
                "'FINALIZADO'" +
                ')" class="btn btn-round btn-warning" rel="tooltip" data-toggle="tooltip" title="Entregado"><i class="fas fa-retweet"></i></a>&nbsp;';
            break;

        case "CANCELADO":
            html +=
                '<a href="javascript:void(0);" onclick="motivoCancelacion(' +
                row.id +
                "," +
                "'COMANDERA'" +
                ')" class="btn btn-round btn-danger" rel="tooltip" data-toggle="tooltip" title="Motivo Cancelado"><i class="fa fa-inbox"></i></a>&nbsp;';
            break;
    }
    return html;
}
//#endregion
