$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    const selectProductos = $("#selectProductos");
    const productosTable = $('#productosTable');

    productosTable.bootstrapTable({
        uniqueId: 'id',
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
                title: 'Producto'
            },
            {
                field: 'precio_venta',
                title: 'Precio unitario'
            },
            {
                field: 'total_venta',
                title: 'Subtotal'
            },
            {
                title: 'Acciones'
            }]
    })

    var productos = {}; // Objeto para almacenar los productos y sus cantidades

    selectProductos.select2({
        width: "100%",
        placeholder: "Seleccione una opción",
        language: {
            noResults: () => "No hay resultado",
            searching: () => "Buscando...",
        },
    });

    selectProductos.on("select2:select", function () {
        let seleccionActual = $("#selectProductos option:selected");
        let seleccionActualID = seleccionActual.val();
        let verificarFila = productosTable.bootstrapTable('getRowByUniqueId', seleccionActualID);
        let dataActual = productosTable.bootstrapTable('getData');
        let agregar = true;

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

        $("#selectProductos").val(0).trigger("change")

    });

});
