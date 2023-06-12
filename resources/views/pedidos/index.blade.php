@extends('layouts.app')

@section('content')

    <style>
        .oculto {
            display: none;
        }
    </style>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Productos</h1>

    </div>
    <div class="card px-2 mt-4 py-4">
        <div class="row gx-2 gy-4">

            <div class="container-fluid py-4">

                <div class="row">

                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive">
                                    <div class="col-md-2">
                                        <strong>Nombre Cliente:</strong>
                                    </div>
                                    <div class="col-md-5">
                                        <select id='searchProduct' name="searchProduct" class="form-control">
                                            <option value="">Seleccione una Opcion</option>

                                            @foreach ($product as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <form action="{{ route('carrito.enviar') }}" method="POST">
                                        @csrf
                                        <ul id="listaProductos"></ul>
                                        <input type="hidden" name="productos" id="productosInput">
                                        <input type="hidden" name="totalCompra" id="totalCompraInput">
                                        <div class="oculto" id="compraForm">
                                            <div id="totalCompra" class="mt-3">Total de la compra: $0.00</div>
                                            <label for="">Codigo de Usuario</label>
                                            <input type="number" id="code_user" name="code_user" class="" required>


                                            <button type="submit">Enviar</button>
                                        </div>
                                    </form>


                                </div>

                            </div>
                            <div class="d-flex justify-content-between align-items-center">

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/pedidos.js') }}"></script>
    <script>
        let routedata = "{{ route('productos.data') }}"
    </script>
@endsection
