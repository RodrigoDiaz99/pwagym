@extends('layouts.app')

@section('content')

    <style>
        .oculto {
            display: none;
        }
    </style>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lista</h1>

    </div>
    <div class="card px-2 mt-4 py-4">
        <div class="row gx-2 gy-4">

            <div class="container-fluid py-4">

                <div class="row">

                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive">

                                    <table class="table align-items-center mb-0  table-responsive" id="table_lista">
                                    </table>

                                </div>

                            </div>
                            <div class="d-flex justify-content-between align-items-center">

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
@include('listado.modal')
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/lista.js')}}"> </script>
<script>
    let routeLista = "{{route('getLista')}}"
    let routeData = "{{route('verProductos')}}"
    let finalizado ="{{route('finalizar')}}"
</script>
@endsection
