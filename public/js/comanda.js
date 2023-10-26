
const comandaTable = $('#comandaTable');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    comandaTable.bootstrapTable({
        url: routeGetComanda,
        uniqueId: 'id',
        detailView: true,
        icons: {
            detailOpen: "fa fa-plus-circle",
            detailClose: "fa fa-minus-circle",
        },
        showFooter: true,
        columns: [

            {
                id: 'id',
                visible: false
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

//#endregion

//#region onEvent

//#endregion


//#region formatters

function PrecioFormatter(value, row) {
    return '$' + value;
}


function AccionesFormatter(value, row) {
    let html = "";

    return html;
}
//#endregion
