@extends('layouts.app')

@section('content')
    <style>
        .oculto {
            display: none;
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
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table id="productosTable"></table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/ordenar.js') }}"></script>
    <script>
        let getProducto = "{{ route('orden.getProducto') }}"
    </script>
@endsection
