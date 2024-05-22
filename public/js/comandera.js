

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
                title: 'Uds.',
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
                formatter: PrecioFormatter
            },
            {
                field: 'total_venta',
                title: 'Subtotal',
                width: 15,
                widthUnit: "%",
                formatter: PrecioFormatter,
                footerFormatter: footerFormatter
            },
            {
                title: 'Acciones',
                width: 25,
                widthUnit: "%",
                formatter: AccionesFormatter,
            }]
    })
    productosTable.bootstrapTable("hideColumn", "precio_venta")
    productosTable.bootstrapTable("hideColumn", "total_venta")

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
function actualizarTotal() {
    let tableData = productosTable.bootstrapTable('getData')
    let totalVenta = 0;
    tableData.forEach(function (row) {
        totalVenta = totalVenta + parseFloat(row.total_venta);
    });
    $("#totalVenta").val(totalVenta)
}

function sumarProducto(id) {
    let producto = productosTable.bootstrapTable('getRowByUniqueId', id);

    let unidades = producto.unidades + 1;
    if (unidades <= producto.cantidad_producto) {
        let total_venta = producto.precio_venta * unidades;
        productosTable.bootstrapTable('updateByUniqueId', {
            id: id,
            row: {
                unidades: unidades,
                total_venta: total_venta
            }
        })
    }
    actualizarTotal()
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
    actualizarTotal()
}

function eliminarProducto(id) {
    productosTable.bootstrapTable('removeByUniqueId', id);
    actualizarTotal();
}

function enviarOrden() {
    $("#err_codigo_usuario").hide();
    let codigo_usuario = $("#codigo_usuario").val();
    let codigo_usuario_cliente = $("#codigo_usuario_cliente").val();
    let comentarios = $("#cComentarios").val();
    let productos = productosTable.bootstrapTable('getData');
    if (productos.length <= 0) {
        $("#err_productosTable").show();
        return false;
    }
    if (codigo_usuario == '') {
        $("#err_codigo_usuario").show();
        return false;
    }

    if (productosTable.bootstrapTable('getData'))


        $.ajax({
            url: routeEnviarOrden,
            type: "post",
            dataType: "json",
            encoding: "UTF-8",
            data: {
                productos: productos,
                total_venta: $("#totalVenta").val(),
                codigo_usuario: codigo_usuario,
                codigo_usuario_cliente: codigo_usuario_cliente,
                comentarios: comentarios
            },
            beforeSend: function () {
                Swal.fire({
                    title: 'Enviando',
                    text: 'Enviando orden, espere un momento...',
                });
                Swal.showLoading();
            },
            success: function (data) {
                Swal.close();
                if (data.lSuccess) {
                    Swal.fire({
                        title: "Correcto",
                        text: data.cMensaje,
                        icon: "success",
                        confirmButtonText: "Aceptar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/pedidos";
                        }
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
}

function agregarProductosAOrden() {
    let pedidos_id = $("#pedidos_id").val();
    let comentarios = $("#cComentarios").val();
    let productos = productosTable.bootstrapTable('getData');
    if (productos.length <= 0) {
        $("#err_productosTable").show();
        return false;
    }

    if (productosTable.bootstrapTable('getData'))


        $.ajax({
            url: routeAgregarProductosAOrden,
            type: "post",
            dataType: "json",
            encoding: "UTF-8",
            data: {
                productos: productos,
                total_venta: $("#totalVenta").val(),
                pedidos_id: pedidos_id,
                comentarios: comentarios
            },
            beforeSend: function () {
                Swal.fire({
                    title: 'Enviando',
                    text: 'Enviando orden, espere un momento...',
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
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/pedidos";
                        }
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
}
//#endregion

//#region onEvent

$("#codigo_usuario").on('input', function () {
    if ($(this).val() != '') {
        $("#err_codigo_usuario").hide();
    } else {
        $("#err_codigo_usuario").show();

    }
})

$(".btnAgregarProducto").on("click", function () {
    let seleccionActualID = $(this).data("producto_id");
    let seleccionActual = $('.objProducto[data-producto_id="' + seleccionActualID + '"]');
    let verificarFila = productosTable.bootstrapTable('getRowByUniqueId', seleccionActualID);

    if (verificarFila == null) {
        productosTable.bootstrapTable('append', ([
            {
                id: seleccionActualID,
                inventario: seleccionActual.data('inventario'),
                cantidad_producto: seleccionActual.data('cantidad_producto'),
                unidades: 1,
                nombre_producto: seleccionActual.data('nombre_producto'),
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
    actualizarTotal();


})

$("#lMostrarPrecios").on("click", function () {
    if ($(this).is(":checked")) {
        productosTable.bootstrapTable("showColumn", "precio_venta")
        productosTable.bootstrapTable("showColumn", "total_venta")
    } else {
        productosTable.bootstrapTable("hideColumn", "precio_venta")
        productosTable.bootstrapTable("hideColumn", "total_venta")
    }
})
selectProductos.on("select2:select", function () {
    $("#err_productosTable").hide();

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

    let suma = data.map(function (row) {
        return +row[field]
    }).reduce(function (sum, i) {
        return sum + i
    }, 0);

    return '$' + suma
}

function PrecioFormatter(value, row) {
    return '$' + value;
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
