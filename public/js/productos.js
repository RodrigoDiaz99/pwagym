
let pedidos_id = null;
const gridProductos = $('#gridProductos');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    gridProductos.bootstrapTable({
        url: routeGridProductos,
        uniqueId: 'id',
        detailView: true,
        columns: [

            {
                id: 'id',
                title: "ID",
                field: "id"
            },
            {
                title: "Nombre",
                field: "nombre_producto"

            },
            {
                field: 'codigo_barras',
                title: "Código",
            },
            {
                field: 'inventario',
                title: '¿Es inventario?',
                formatter: function (value, row) {
                    if (row.inventario == 1) {
                        return "Sí";
                    } else {
                        return "No";
                    }
                }
            },
            {
                field: 'precio_venta',
                title: 'Precio de venta',
                formatter: 'PrecioFormatter'
            },
        ],
    })


});

//#region funciones
//#endregion

//#region onEvent

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
