

let selectProductos = $("#selectProductos");
const productosTable = $('#productosTable');
$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    productosTable.bootstrapTable({
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
                title: '#',
                width: 5,
                widthUnit: "%",
                formatter: function (value, row, index) {
                    return index + 1;
                },
            },
            {
                field: 'unidades',
                title: 'Unidades',
                width: 5,
                widthUnit: "%",
            },
            {
                field: 'nombre_producto',
                title: 'Producto',
                width: 35,
                widthUnit: "%",
            },
            {
                field: 'precio_venta',
                title: 'Precio unitario',
                width: 15,
                widthUnit: "%",
            },
            {
                field: 'total_venta',
                title: 'Subtotal',
                width: 15,
                widthUnit: "%",
                footerFormatter: footerFormatter
            },
            {
                title: 'Acciones',
                width: 25,
                widthUnit: "%",
                formatter: AccionesFormatter,
            }]
    })


    selectProductos.select2({
        width: "100%",
        placeholder: "Seleccione una opción",
        language: {
            noResults: () => "No hay resultado",
            searching: () => "Buscando...",
        },
    });




});

//#region funciones
function sumarProducto(id) {
    let producto = productosTable.bootstrapTable('getRowByUniqueId', id);

    let unidades = producto.unidades + 1;
    let total_venta = producto.precio_venta * unidades;
    productosTable.bootstrapTable('updateByUniqueId', {
        id: id,
        row: {
            unidades: unidades,
            total_venta: total_venta
        }
    })
}

function restarProducto(id) {
    let producto = productosTable.bootstrapTable('getRowByUniqueId', id);

    let unidades = producto.unidades - 1;
    if (unidades <= 0) {
        productosTable.bootstrapTable('removeByUniqueId', id);
        return true;
    }
    let total_venta = producto.precio_venta * unidades;
    productosTable.bootstrapTable('updateByUniqueId', {
        id: id,
        row: {
            unidades: unidades,
            total_venta: total_venta
        }
    })
}

function eliminarProducto(id) {
    productosTable.bootstrapTable('removeByUniqueId', id);

}
//#endregion

//#region onEvent
selectProductos.on("select2:select", function () {
    let seleccionActual = $("#selectProductos option:selected");
    let seleccionActualID = seleccionActual.val();
    let verificarFila = productosTable.bootstrapTable('getRowByUniqueId', seleccionActualID);

    if (verificarFila == null) {
        productosTable.bootstrapTable('append', ([
            {
                id: seleccionActual.val(),
                inventario: seleccionActual.data('inventario'),
                cantidad_producto: seleccionActual.data('cantidad_producto'),
                unidades: 1,
                nombre_producto: seleccionActual.text(),
                precio_venta: seleccionActual.data('precio_venta'),
                total_venta: seleccionActual.data('precio_venta')
            }
        ]))

    } else {
        let unidades = verificarFila.unidades + 1;
        let total_venta = verificarFila.precio_venta * unidades;
        productosTable.bootstrapTable('updateByUniqueId', {
            id: seleccionActualID,
            row: {
                unidades: unidades,
                total_venta: total_venta
            }
        })
    }

    selectProductos.val(0).trigger("change")

});
//#endregion


//#region formatters
function footerFormatter(data) {
    var field = 'total_venta'
    return '$' + data.map(function (row) {
        return +row[field]
    }).reduce(function (sum, i) {
        return sum + i
    }, 0)
}

function AccionesFormatter(value, row) {
    return `
    <div class="row">
    <div class="col-md-auto"> <button onclick="sumarProducto(${row.id})" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button> </div>
    <div class="col-md-auto"><button onclick="restarProducto(${row.id})" type="button" class="btn btn-primary"><i class="fa fa-minus" aria-hidden="true"></i></button></div>
    <div class="col-md-auto"><button onclick="eliminarProducto(${row.id})" type="button" class="btn btn-primary"><i class="fa fa-trash" aria-hidden="true"></i></button></div>
    </div>
    `;
}
//#endregion
