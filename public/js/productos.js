$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    /**bootstrap table del grid de expediente */
    const $gridExpediente = $("#table_producto");

    $gridExpediente.bootstrapTable({
        url: routeProduct,
        classes: "table-striped",
        method: "post",
        contentType: "application/x-www-form-urlencoded",
        locale: "es-MX",
        pagination: true,
        pageSize: 10,
        search:true,
        columns: [
            {
                field: "iIDProducto",
                visible: false,
            },
            {
                field: "nombre_producto",
                title: "Producto",
            },

            {
                field: "cedicion",
                title: "Acciones",
                formatter: "accionesFormatter",
            },
        ],
    });
    $("#btnClose", "#btnCerrar").on("click", function () {
        $("#cCodeBar").val("");
        $("#price").val("");
    });


});
function accionesFormatter(value, row) {
    let html = "";
    console.log(row);
   html+='<a href="javascript:void(0);"  onclick="ModalDetalles(' +
    row.codigo_barras +
    "," +
    row.precio_venta +
    ')" class="btn btn-round btn-primary btn-icon btn-sm" rel="tooltip" data-toggle="tooltip" title="Modificar Archivos"><i class="fas fa-info-circle"></i></a>&nbsp;';

    return html;
}

function ModalDetalles(cCodeBar, Price) {
    $("#ModalDetalles").modal("show");
    $("#cCodeBar").val(cCodeBar);
    $("#price").val(Price);
}
