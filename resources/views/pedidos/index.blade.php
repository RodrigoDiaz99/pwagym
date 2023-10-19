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
        <h1 class="h3 mb-0 text-gray-800">Pedidos</h1>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <table id="gridPedidos" class="table align-items-center mb-0 ">
                    </table>
                </div>
            </div>

        </div>
    </div>
    @include('pedidos.modals.modalDetalles')
    @include('pedidos.modals.modalCancelarPedido')
@endsection
@section('scripts')
    <script src="{{ asset('js/pedidos.js') }}"></script>
    <script>
        let routeGetPedidos = "{{ route('pedidos.getPedidos') }}"
        let routeCambiarEstatus = "{{ route('pedidos.cambiarEstatus') }}"
    </script>
@endsection
