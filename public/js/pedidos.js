
let pedidos_id = null;
const pedidosTable = $('#gridPedidos');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    pedidosTable.bootstrapTable({
        url: routeGetPedidos,
        uniqueId: 'id',
        // detailView: true,
        // icons: {
        //     detailOpen: "fa fa-plus-circle",
        //     detailClose: "fa fa-minus-circle",
        // },
        showFooter: true,
        columns: [
            {
                field: 'detalles',
                visible: true,
                formatter: function (value, row) {
                    return '<button class="btn btn-primary" onclick="verDetallesPedido(' + row.id + ')"><i class="fa fa-plus-circle"></i></button>';
                }
            },
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
                , visible: false

            },

            {
                field: 'linea_referencia',
                title: 'Línea de referencia',
                visible: false,
            },

            {
                field: 'created_at',
                title: 'Fecha y hora',
                width: 25,
                widthUnit: "%",
                formatter: function (value, row) {
                    return moment(row.created_at).format("DD/MM/YYYY h:mm:ssa");
                }
            },
            {
                field: 'estatus',
                title: 'Estado',
                width: 15,
                widthUnit: "%",
            },
            {
                field: 'precio',
                title: 'Total',
                formatter: PrecioFormatter
                , visible: false
            },

            {
                title: 'Acciones',
                formatter: AccionesFormatter
            }],
        onExpandRow: function (index, row, $detail) {
            /*     let detallesHTML = "<table class='table  detalles' cellspacing='0'></table>";
                let productosHTML = "<table class='table  productos' cellspacing='0'></table>";

                let combinedHTML = detallesHTML + productosHTML;

                $detail.html(combinedHTML);

                let detallesTable = $detail.find(".detalles");
                let productosTable = $detail.find(".productos");

                // Now you can work with 'detallesTable' and 'productosTable' as needed
                gridDetallesPedido(row, detallesTable, productosTable);

     */
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
                pedidosTable.bootstrapTable('refresh', { silent: true });
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
        },
    });
}

function cancelarPedido(id) {
    $("#tituloCancelarPedido").text(`Cancelar pedido #${id}`)
    $("#motivoCancelacion").val("");
    $("#pedidos_id").val(id);
    $("#modalCancelarPedido").modal("show");
}

function gridDetallesPedido(row, gridDetallesPedido, gridProductosPedido) {
    gridDetallesPedido.bootstrapTable({
        theadClasses: "thead-dark",
        columns: [
            {
                field: "encargado",
                title: "Encargado",

            },
            {
                field: 'comentarios',
                title: 'Comentarios',
            },
        ]
    });

    gridDetallesPedido.bootstrapTable('append', ([
        {
            encargado: `${row.users.nombre} ${row.users.apellido_paterno} ${row.users.apellido_materno}`,
            comentarios: row.comentarios,

        }
    ]))

    gridProductosPedido.bootstrapTable({
        url: routeGetDetallesPedido,
        contentType: "application/x-www-form-urlencoded",
        theadClasses: "thead-dark",
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

function verDetallesPedido(id) {
    let lstProductos = $("#detalleProductos");
    $.ajax({
        url: routeGetDetallesPedido,
        type: "post",
        encoding: "UTF-8",
        async: true,
        cache: false,
        data: {
            id: id,
        },
        beforeSend: function () {
            Swal.fire({
                title: "Cargando",
                text: "Espere un momento",
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
                let nombre = `${data.pedido.users.nombre} ${data.pedido.users.apellido_paterno} ${data.pedido.users.apellido_materno}`;
                $("#modalDetallesPedido").modal("show");
                $("#detalleEncargado").text(nombre);
                $("#detalleDatetime").text(moment(data.pedido.created_at).format("DD/MM/YYYY h:mm:ssa"));
                $("#detalleLineaReferencia").text(data.pedido.linea_referencia);
                $("#detalleEstatus").text(data.pedido.estatus);
                let productos = data.pedido.productos;
                lstProductos.empty();
                $.each(productos, function (index, producto) {
                    let txt = `${producto.nombre_producto} x${producto.pivot.cantidad}`
                    $("<li>").text(txt).appendTo(lstProductos);
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
        error: function (err) {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error desconocido.",
                icon: "error",
                confirmButtonText: "Aceptar",
            });
        },
    });
}

//#endregion

//#region onEvent
$("#btnCancelarPedido").on("click", function () {
    cambiarEstatus($("#pedidos_id").val(), "CANCELADO")
})

$("#btnActualizarPedidos").on("click", function () {
    $("#gridPedidos").bootstrapTable("refresh");
    $("#gridPedidos").bootstrapTable("removeAll");
    $(".productos").bootstrapTable("refresh");

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
                '<a href="/comandera/agregarProductos/' + row.id + '" onclick="agregarProductos(' +
                row.id +
                ')" class="btn btn-round btn-success" rel="tooltip" data-toggle="tooltip" title="Agregar productos"><i class="fas fa-plus"></i></a>&nbsp;';
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
            html +=
                '<a href="/comandera/agregarProductos/' + row.id + '" onclick="agregarProductos(' +
                row.id +
                ')" class="btn btn-round btn-success" rel="tooltip" data-toggle="tooltip" title="Agregar productos"><i class="fas fa-plus"></i></a>&nbsp;';
            html +=
                '<a href="javascript:void(0);" onclick="cambiarEstatus(' +
                row.id +
                "," +
                "'PREPARACIÓN'" +
                ')" class="btn btn-round btn-warning" rel="tooltip" data-toggle="tooltip" title="Elaboracion"><i class="fas fa-retweet"></i></a>&nbsp;';
            html +=
                '<a href="javascript:void(0);" onclick="cancelarPedido(' +
                row.id + ')" class="btn btn-round btn-danger" rel="tooltip" data-toggle="tooltip" title="Rechazar"><i class="fas fa-ban"></i></a>&nbsp;';
            break;
        case "PREPARACIÓN":
            html +=
                '<a href="/comandera/agregarProductos/' + row.id + '" onclick="agregarProductos(' +
                row.id +
                ')" class="btn btn-round btn-success" rel="tooltip" data-toggle="tooltip" title="Agregar productos"><i class="fas fa-plus"></i></a>&nbsp;';
            html +=
                '<a href="javascript:void(0);" onclick="cambiarEstatus(' +
                row.id +
                "," +
                "'LISTO'" +
                ')" class="btn btn-round btn-warning" rel="tooltip" data-toggle="tooltip" title="Listo"><i class="fas fa-retweet"></i></a>&nbsp;';
            html +=
                '<a href="javascript:void(0);" onclick="cancelarPedido(' +
                row.id + ')" class="btn btn-round btn-danger" rel="tooltip" data-toggle="tooltip" title="Rechazar"><i class="fas fa-ban"></i></a>&nbsp;';
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
