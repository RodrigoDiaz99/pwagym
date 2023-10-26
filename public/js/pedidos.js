
let pedidos_id = null;
const pedidosTable = $('#gridPedidos');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    pedidosTable.bootstrapTable({
        url: routeGetPedidos,
        uniqueId: 'id',
        detailView: true,
        icons: {
            detailOpen: "fa fa-plus-circle",
            detailClose: "fa fa-minus-circle",
        },
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
                title: "Encargado",
                formatter: function (value, row) {
                    return `${row.users.nombre} ${row.users.apellido_paterno} ${row.users.apellido_materno}`;
                }
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
            }],
        onExpandRow: function (index, row, $detail) {
            let tableHTML = "<table class='table' cellspacing='0'></table>";
            gridDetallesPedido(row, $detail.html(tableHTML).find("table"));
        },
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

function gridDetallesPedido(row, gridDetallesPedido) {
    gridDetallesPedido.bootstrapTable({
        url: routeGetDetallesPedido,
        contentType: "application/x-www-form-urlencoded",
        method: "POST",
        queryParams: function (p) {
            return {
                pedidos_id: row.id,
            };
        },
        columns: [
            {
                id: 'id',
                visible: false
            },
            {
                title: "Producto",
                field: 'nombre_producto'
            },
            {
                title: 'Cantidad',
                field: 'pivot.cantidad',
            },
            {
                title: 'Precio unitario',
                formatter: function (value, row) {
                    return `$${row.precio_venta}`;
                },
            },
            {
                title: 'Subtotal',
                formatter: function (value, row) {
                    let Subtotal = row.precio_venta * row.pivot.cantidad;
                    return `$${Subtotal}`;
                },
            },
        ]
    })
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
