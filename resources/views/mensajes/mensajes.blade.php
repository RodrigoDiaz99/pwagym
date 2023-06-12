@if (Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: "{{ Session::get('success') }}",
            confirmButtonText: 'Aceptar'
        })
    </script>
@elseif (Session::has('updated'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Éxito',
            text: "{{ Session::get('updated') }}",
            confirmButtonText: 'Aceptar'
        })
    </script>
@elseif (Session::has('deleted'))
    <script>
        Swal.fire({
            icon: 'question',
            title: 'Eliminado',
            text: "{{ Session::get('deleted') }}",
            confirmButtonText: 'Cerrar'
        })
    </script>
@elseif (Session::has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ Session::get('error') }}",
            confirmButtonText: 'Cerrar'
        })
        console.log("{{ Session::get('code') }}");
    </script>
    @elseif(Session::has('restored'))

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Exito',
            text: "{{ Session::get('restored') }}",
            confirmButtonText: 'Cerrar'
        })
        console.log("{{ Session::get('code') }}");
    </script>
@elseif (Session::has('errores'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ Session::get('error') }}",
        confirmButtonText: 'Cerrar'
    })
    console.log("{{ Session::get('code') }}");
</script>
@endif

