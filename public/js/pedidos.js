$(function ($) {
    $.ajaxSetup({
        headers: { "X-CSRF-Token": $("meta[name=csrf-token]").attr("content") },
    });

    const $searchProduct = $("#searchProduct");
    var productos = {}; // Objeto para almacenar los productos y sus cantidades

    $searchProduct.select2({
        width: "100%",
        placeholder: "Seleccione una Opcion",
        language: {
            noResults: () => "No hay resultado",
            searching: () => "Buscando..",
        },
    });

    $("#searchProduct").on("select2:select", function (e) {
        var producto = e.params.data.text;
        agregarProducto(producto);
        limpiarSeleccion();
    });

    function agregarProducto(producto) {
        $.ajax({
            url:routedata,
            type: 'POST',
            data: { producto: producto },
            success: function (response) {
                var precioUnitario = response[0].sales_price;
                if (productos.hasOwnProperty(producto)) {
                    // Si el producto ya existe en el carrito, se incrementa la cantidad
                    productos[producto].cantidad++;
                } else {
                    // Si el producto no existe en el carrito, se agrega con cantidad 1 y el precio obtenido
                    productos[producto] = {
                        cantidad: 1,
                        precio: precioUnitario
                    };
                }
                actualizarListaProductos();
                actualizarTotalCompra();
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

  function actualizarListaProductos() {
    var listaProductos = $('#listaProductos');
    listaProductos.empty();

    var total = 0; // Variable para calcular el total de la compra

    for (var producto in productos) {
        console.log(productos);
        var item = productos[producto];
        var cantidad = item.cantidad;
        var precioUnitario = item.precio;
        var subtotal = cantidad * precioUnitario;
        total += subtotal;

        // Crear elementos <li> para mostrar los detalles del producto
        var li = $('<li>').addClass('list-group-item').text(producto + ' (').append($('<span>').addClass('badge bg-primary rounded-pill text-white').text(cantidad)).append('), Precio: $' + precioUnitario.toFixed(2) + ', Total: $' + subtotal.toFixed(2));





        // Agregar botones de incrementar, reducir y eliminar
        //var btnMas = $('<button>').addClass('btn btn-primary').attr('data-producto', producto).text('+').prepend($('<i>').addClass('fas fa-plus'));

        var btnMas = $('<button>').addClass('btn btn-primary').attr('data-producto', producto).addClass('incrementar-cantidad').prepend($('<i>').addClass('fas fa-plus'));
        var btnMenos = $('<button>').addClass('btn btn-warning').attr('data-producto', producto).addClass('reducir-cantidad').prepend($('<i>').addClass('fas fa-minus'));
        var btnEliminar = $('<button>').addClass('btn btn-danger').attr('data-producto', producto).addClass('eliminar-producto').prepend($('<i>').addClass('fas fa-trash'));

        // Agregar los botones al elemento <li>
        li.append(btnMenos).append(btnMas).append(btnEliminar);

        // Agregar el elemento <li> a la lista de productos
        listaProductos.append(li);
    }

    // Actualizar el campo de entrada oculto con los datos de los productos
    $('#productosInput').val(JSON.stringify(productos));

    // Actualizar el total de la compra
    $('#totalCompra').text('Total de la compra: $' + total.toFixed(2));
    $('#totalCompraInput').val(total.toFixed(2));
    mostrarOcultarFormulario();
    // Manejar eventos de los botones
    $('.incrementar-cantidad').on('click', function (e) {
        e.preventDefault();
        var producto = $(this).data('producto');
        productos[producto].cantidad++;
        actualizarListaProductos();
        actualizarTotalCompra();
    });

    $('.reducir-cantidad').on('click', function (e) {
        e.preventDefault();
        var producto = $(this).data('producto');
        if (productos[producto].cantidad > 1) {
            productos[producto].cantidad--;
            actualizarListaProductos();
            actualizarTotalCompra();
        }
    });

    $('.eliminar-producto').on('click', function (e) {
        e.preventDefault();
        var producto = $(this).data('producto');
        delete productos[producto];
        actualizarListaProductos();
        actualizarTotalCompra();
    });
}


    function limpiarSeleccion() {
        $('#searchProduct').val('').trigger('change.select2');
    }

    function actualizarTotalCompra() {
        var total = 0;

        for (var producto in productos) {
            var item = productos[producto];
            var cantidad = item.cantidad;
            var precioUnitario = item.precio;
            var subtotal = cantidad * precioUnitario;
            total += subtotal;
            console.log(total)

        }

        // Update the total purchase amount in the HTML element
        $('#totalCompra').text('Total de la compra: $' + total.toFixed(2));

        // Update the value of the hidden input field with the total amount

    }

    function mostrarOcultarFormulario() {
        var listaProductos = $('#listaProductos');
        var compraForm = $('#compraForm');
        if (listaProductos.children().length > 0) {
            compraForm.removeClass('oculto');
        } else {
            compraForm.addClass('oculto');
        }
    }

    $('form').on('submit', function () {
        $('input[name="productos"]').val(JSON.stringify(productos));
    });

});
