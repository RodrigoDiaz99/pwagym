 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-female"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SpacioFems</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <!-- Divider -->
    <hr class="sidebar-divider">





    <!-- Heading -->
    <div class="sidebar-heading">
        Opciones
    </div>



    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('product.view')}}">
            <i class="fas fa-store"></i>
            <span>Products</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('pedidos.view')}}">
            <i class="fa fa-th-large"></i>
            <span>Ordenar</span></a>
    </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="{{route('ordenes.index')}}">
            <i class="fa fa-list"></i>
            <span>Pedidos</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('listado.view')}}">
            <i class="fa fa-list"></i>
            <span>Comanda</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
