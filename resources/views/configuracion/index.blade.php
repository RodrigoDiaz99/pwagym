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
        <h1 class="h3 mb-0 text-gray-800">Configuración</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <label for="numero_orden" class="form-label">Número de orden del día</label>
                    <input id="numero_orden" type="text" class="form-control number" name="numero_orden" aria-describedby="helpId" placeholder=""
                        value="{{ $configuracion->numero_orden }}">
                    <small id="helpId" class="form-text text-muted">Es el número de con la que la siguiente orden será creada.</small>
                </div>

            </div>
            <div class="row">
                <div class="col-md">
                    <button type="button" id="btnGuardarConfiguracion" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Guardar configuración</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/configuracion.js') }}"></script>
    <script>
        let routeGuardarConfiguracion = "{{ route('configuracion.guardarConfiguracion') }}"
    </script>
@endsection
