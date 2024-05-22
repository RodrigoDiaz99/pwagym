@extends('layouts.app')

@section('content')
    <style>
        .oculto {
            display: none;
        }

        .row {
            margin-bottom: .5rem;
        }

        .card {
            margin-bottom: .2rem;
            margin-top: .2rem;

        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Comandera</h1>
    </div>

    {{--     <div id="seccionTipoPedido" class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-md"> Área:</div>
            </div>
            <div class="row">
                <div class="col-md">
                    <button type="button" class="btn btn-primary">Comedor</button>
                </div>
                <div class="col-md">
                    <button type="button" class="btn btn-primary">Recoger</button>
                </div>
            </div>


        </div>
    </div> --}}
    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <div class="form-group">
                    <strong>Cliente que ordenó</strong>
                    <select id="codigo_usuario_cliente" class="form-control" name="codigo_usuario_cliente">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->codigo_usuario }}">{{ $cliente->codigo_usuario }} - {{ $cliente->nombre }}
                                {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }} </option>
                        @endforeach

                    </select>
                </div>
                <label id="err_codigo_usuario" for="codigo_usuario" class="text-danger" style="display:none;">Este campo es requerido.</label>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Productos</h4>
            <div class="row">
                @foreach ($productos as $producto)
                    <div class="col-lg-2 objProducto" value="{{ $producto->id }}" data-producto_id="{{ $producto->id }}"
                        data-cantidad_producto="{{ $producto->cantidad_producto }}" data-inventario="{{ $producto->inventario }}"
                        data-precio_venta="{{ $producto->precio_venta }}" data-nombre_producto = "{{ $producto->nombre_producto }}" class="cardProducto">
                        <div class="card">
                            <div class="card-body">
                                <b> {{ $producto->nombre_producto }}</b>
                                <div>${{ $producto->precio_venta }}</div>

                                {{--   <div class="form-group">
                                    <label for="cNotaProducto">Comentarios:</label>
                                    <textarea id="cNotaProducto" class="form-control" name="cNotaProducto" rows="3" style="resize: none;"></textarea>
                                </div> --}}

                                <button type="button" class="btn btn-success btnAgregarProducto col" data-producto_id="{{ $producto->id }}"><i
                                        class="fa fa-plus-circle" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div id="seccionPedido" class="card">
        <div class="card-body">
            <div class="row justify-content-end">
                <div class="col-md-auto">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input id="lMostrarPrecios" class="form-check-input" type="checkbox" name="lMostrarPrecios"> Mostrar precios
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="productosTable"></table>
                    <input id="totalVenta" type="hidden">
                </div>
            </div>

        </div>
    </div>

    <div id="seccionEnviar" class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label for="cComentarios">Comentarios:</label>
                        <textarea id="cComentarios" class="form-control" name="cComentarios" rows="3" style="resize: none"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-auto">

                    <div class="mb-2">
                        <div class="form-group">
                            <strong>Usuario para asignar</strong>
                            <select id="codigo_usuario" class="form-control" name="codigo_usuario">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->codigo_usuario }}">{{ $usuario->codigo_usuario }} - {{ $usuario->nombre }}
                                        {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }} </option>
                                @endforeach

                            </select>
                        </div>
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
    <script src="{{ asset('js/comandera.js') }}"></script>
    <script>
        let routeGetProducto = "{{ route('comandera.getProducto') }}"
        let routeEnviarOrden = "{{ route('comandera.enviarOrden') }}"
    </script>
@endsection
