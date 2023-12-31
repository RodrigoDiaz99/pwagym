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
        <h1 class="h3 mb-0 text-gray-800">Comanda</h1>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <table id="gridPedidosComanda" class="table align-items-center mb-0 ">
                    </table>
                </div>
            </div>

        </div>
    </div>
    @include('comanda.modals.modalDetalleComanda')
@endsection
@section('scripts')
    <script src="{{ asset('js/comanda.js') }}"></script>
    <script>
        let routeGridPedidosComanda = "{{ route('comanda.gridPedidosComanda') }}"
        let routeGetDetallesPedido = "{{ route('comanda.getDetallesPedido') }}"
    </script>
@endsection
