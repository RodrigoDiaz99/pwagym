<!DOCTYPE html>
<html lang="en">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/spacio.png') }}" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('styles/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="{{ asset('styles/css/sb-admin-2.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="
        //cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js
        "></script>
    <link href="
    //cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('{{ asset('serviceWorker') }}').then(function(registration) {
                    console.log('Service Worker registrado con éxito:', registration);
                }).catch(function(error) {
                    console.log('Error al registrar el Service Worker:', error);
                });
            });
        }
    </script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')
                    @include('mensajes.mensajes')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('layouts.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    @include('layouts.modal')

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('styles/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('styles/vendor/bootstrap/js/bootstrap.bundle.min.j') }}s"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/plugins/moment.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('styles/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('styles/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('styles/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    {{--  <script src="{{ asset('styles/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('styles/js/demo/chart-pie-demo.js') }}"></script> --}}

    <!-- Latest compiled and minified Locales -->
    <script src="{{ url('//cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js') }}"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="{{ url('//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js') }}"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>



    <script src="{{ url('//code.jquery.com/jquery-3.6.1.js') }}" crossorigin="anonymous"></script>
    <link href="{{ url('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ url('//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>

    <script src="{{ url('//code.jquery.com/ui/1.13.2/jquery-ui.js') }}"></script>
    <script src="{{ url('//cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js') }}"></script>

    <!-- BootstrapTable Library -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <!-- Latest compiled and minified Locales -->
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/locale/bootstrap-table-es-MX.min.js"></script>


    @yield('scripts')
</body>

</html>
