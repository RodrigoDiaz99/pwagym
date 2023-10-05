@extends('layouts.app')

@section('content')
    <style>
        .oculto {
            display: none;
        }

        .row {
            margin-bottom: .5rem;
        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ordenar</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <strong>Productos:</strong>
                    <select id="selectProductos" name="selectProductos" class="form-control">
                        <option value="">Seleccione una opción</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" data-cantidad_producto="{{ $producto->cantidad_producto }}"
                                data-inventario="{{ $producto->inventario }}" data-precio_venta="{{ $producto->precio_venta }}">
                                {{ $producto->nombre_producto }}
                            </option>
                        @endforeach
                    </select>
                    <label id="err_productosTable" for="selectProductos" class="text-danger" style="display:none;">Debe agregar productos.</label>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="productosTable"></table>
                    <input id="totalVenta" type="hidden">
                </div>
            </div>
            <div class="row">
                <div class="col-md-auto">
                    <div class="mb-2">
                        <strong>Código de usuario</strong>
                    </div>
                    <div class="mb-2">
                        <input id="codigo_usuario" type="text" class="form-control">
                        <label id="err_codigo_usuario" for="codigo_usuario" class="text-danger" style="display:none;">Este campo es requerido.</label>
                    </div>
                    <div class="mb-2">
                        <button id="btnEnviar" onclick="enviarOrden()" type="button" class="btn btn-primary">Enviar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/ordenar.js') }}"></script>
    <script>
        let routeGetProducto = "{{ route('orden.getProducto') }}"
        let routeEnviarOrden = "{{ route('orden.enviarOrden') }}"
    </script>
@endsection
