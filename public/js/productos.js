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

        columns: [
            {
                field: "iIDProducto",
                visible: false,
            },
            {
                field: "cNombreProduct",
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
    html +=
        '<a rel="tooltip" title="Detalles" class="btn btn-link btn-primary table-action view" href="javascript:void(0)" onclick="ModalDetalles(' +
        row.cCodeBar +
        "," +
        row.price +
        ')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16"><path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/><path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/></svg></a>&nbsp;';
    return html;
}

function ModalDetalles(cCodeBar, Price) {
    $("#ModalDetalles").modal("show");
    $("#cCodeBar").val(cCodeBar);
    $("#price").val(Price);
}
